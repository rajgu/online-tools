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

}

