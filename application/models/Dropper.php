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
	* @data: BATCH_SIZE
	* Wielkosc paczki domen do pojedynczego importu do bazy danych.
	*
	*/

	private $BATCH_SIZE = 500;

	/*
	*
	* @array: DROPPER_LIST
	* Lista rozszerzeń, wraz z nazwami klas do pobierania z zewnetrznych źródeł.
	*
	*/

	private $DROPPER_LIST = array (
		'pl'	      => 'dropper_pl',
		'com'         => 'dropper_com',
		'cc'	      => 'dropper_cc',
		'xyz'         => 'dropper_xyz',
		'org'         => 'dropper_org',
		'net'         => 'dropper_net',
		'us'          => 'dropper_us',
		'info'        => 'dropper_info',
		'biz'         => 'dropper_biz',
		'tv'          => 'dropper_tv',
		'online'      => 'dropper_online',
		'website'     => 'dropper_website',
		'mobi'        => 'dropper_mobi',
		'com.co'      => 'dropper_com_co',
		'london'      => 'dropper_london',
		'me'          => 'dropper_me',
		'work'        => 'dropper_work',
		'email'       => 'dropper_email',
		'global'      => 'dropper_global',
		'club'        => 'dropper_club',
		'photography' => 'dropper_photography',
		'koeln'       => 'dropper_koeln',
		'space'       => 'dropper_space',
		'co'          => 'dropper_co',
		'pro'         => 'dropper_pro',
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

		if (! $this->load->is_loaded ('connector'))
			$this->load->model ('connector');

		if (! $this->load->is_loaded ('dropper_snapnames'))
			$this->load->model ('dropper/dropper_snapnames');

	}

	/*
	*
	* @function: __save
	* Metoda zapisuje pobrane domeny do bazy danych,
	*
	*/

	private function __save ($params) {

		$size = count ($params['data']);
		$insert = array ();
		$licznik = 0;

		foreach ($params['data'] AS $domain) {

			$domain_utf = idn_to_utf8 ($domain['name']);
			$domain_idn = idn_to_ascii ($domain['name']);

			$tinsert = array (
				'name'		   => $domain_utf,
				'name_idn'	   => $domain_idn,
				'extension'	   => $params['extension'],
				'date_dropped' => $domain['date'],
			);


			if (mb_check_encoding ($tinsert['name'], "UTF-8") AND
				mb_detect_encoding ($tinsert['name'], 'UTF-8', true)) {
				$insert[] = $tinsert;
			}

			if ($licznik != 0 AND ($licznik % $this->BATCH_SIZE == 0 OR $licznik > $size)) {

				$search_domains = array_map (function ($x) {return $x['name']; }, $insert);

				$this->db->from ($this->DROPPER_TABLE);
				$this->db->where_in ('name', $search_domains);
				$query = $this->db->get ();

				$results = $query->result_array ();

				if (! empty ($results)) {
					$isize = count ($insert);
					foreach ($results AS $res) {
						for ($i = 0; $i < $isize; $i++) {
							if (isset ($insert[$i]) AND ($res['name'] == $insert[$i]['name'])) {
								unset ($insert[$i]);
							}
						}
					}
				}

				if (! empty($insert))
					$this->db->insert_batch ($this->DROPPER_TABLE, $insert);

				$insert = array ();
			}

			$licznik++;
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

			if (! $data) {
				$this->logger->fatal (array ('Failed do get expired ', $extension, ' domains'));
				continue;
			}

			$this->__save (array (
				'data'	  => $data,
				'extension' => $extension,
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
			'page'	=> (int) $page,
			'pages'   => (int) $pages,
			'domains' => $result->result_array (),
		);
	}

}

