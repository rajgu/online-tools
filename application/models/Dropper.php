<?php

	/*
	*
	* @model: dropper
	* Moduł obsługujący pobieranie i kasowanie przez CRON-y listy dropowanych domen
	*
	*/

class Dropper extends CI_Model {

	/*
	*
	* @data: DROPPER_TABLE
	* Nazwa tabeli przechowujacej liste porzuconych domen.
	*
	*/

	private $DROPPER_TABLE = 'dropped_domains';

	/*
	*
	* @array: DROPPER_LIST
	* Lista rozszerzeń, wraz z nazwami klas do pobierania z zewnetrznych źródeł.
	*
	*/

	private $DROPPER_LIST = array (
		'pl'	=> 'dropper_pl',
	);

	/*
	*
	* @data: DROPPER_LIMIT
	* Stała określająca liczbę domen pobieranych jednym zapytaniem.
	*
	*/

	private $DROPPER_LIMIT = 100;

	/*
	*
	* @function: __construct
	* Konstruktor.
	*
	*/

	public function __construct () {

		if (! $this->load->is_loaded ('connector')) {
			$this->load->model ('connector');
		}

	}

	/*
	*
	* @function: __save
	* Metoda zapisuje pobrane domeny do bazy danych,
	*
	*/

	private function __save ($params) {

		foreach ($params['domains'] AS $domain) {

			$domain_utf = idn_to_utf8 ($domain);
			$domain_idn = idn_to_ascii ($domain);

			$query = $this->db->get_where ($this->DROPPER_TABLE, array ('name' => $domain_utf));

			if (! empty ($query->result ()) or ! $domain)
				continue;

			$this->db->insert ($this->DROPPER_TABLE, array (
				'name'         => $domain_utf,
				'name_idn'     => $domain_idn,
				'extension'    => $params['extension'],
				'date_dropped' => $params['drop_date'],
			));
		}

	}


	/*
	*
	* @function: process
	* Główna funkcja, tworzy odpowiednie klasy do pobierania domen i zapisuje wyniki.
	*
	*/

	public function process () {

		foreach ($this->DROPPER_LIST AS $extension => $class) {

			$this->load->model ("dropper/${class}");
			$data = $this->$class->getDroppedDomains ();

			$this->__save (array (
				'domains'   => $data['domains'],
				'extension' => $extension,
				'drop_date' => $data['date'],
			));

		}

	}

	/*
	*
	* @function: makeStats
	* Funkcja, generuje statystyki dla usuniętych domen trzymanych w bazie danych.
	*
	*/

	public function makeStats ($extension = false) {

		$this->db->from ($this->DROPPER_TABLE);

		$this->db->select ('count(*) AS ilosc, extension');

		if ($extension)
			$this->db->where ('extension', $extension);

		$this->db->group_by ('extension');
		$result = $this->db->get ();
		$data = $result->result_array ();

		if (! $data OR empty ($data))
			return false;

		$return = array ();
		foreach ($data as $domain_data)
			$return[$domain_data['extension']] = $domain_data['ilosc'];

		return $return;
	}

	/*
	*
	* @function: getDomains
	* Funkcja, do wyszukiwania domen trzymanych w bazie danych.
	*
	*/

	public function getDomains ($page = 0, $extension = false, $name = false) {

		$this->db->from ($this->DROPPER_TABLE);
		if ($name)
			$this->db->where ("MATCH (name) AGAINST ('*${name}*' IN BOOLEAN MODE)", NULL, FALSE);
		if ($extension)
			$this->db->where ('extension', $extension);

		$pages = floor ($this->db->count_all_results () / $this->DROPPER_LIMIT);

		$this->db->from ($this->DROPPER_TABLE);
		if ($name)
			$this->db->where ("MATCH (name) AGAINST ('*${name}*' IN BOOLEAN MODE)", NULL, FALSE);
		if ($extension)
			$this->db->where ('extension', $extension);

		$this->db->limit ((int) $this->DROPPER_LIMIT, (int) $page * $this->DROPPER_LIMIT);

		$result = $this->db->get ();

		return array (
			'page'    => (int) $page,
			'pages'   => (int) $pages,
			'domains' => $result->result_array (),
		);
	}

}

