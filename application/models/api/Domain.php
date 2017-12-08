<?php

/*
*
* @model: domain
* Obsługa wywołań api dla domen.
*
*/

class Domain extends CI_Model {

	/*
	*
	* @function: __construct
	* Konstruktor pobiera parametry żądania z klasy request.
	*
	*/

	public function __construct () {

		$this->params = $this->request->getParams ();
	}
	
	/*
	*
	* @function: whois
	* Zwraca wynik whois-a dla zadanej domeny.
	*
	*/

	public function whois () {

		$this->load->library ('Whois');

		$data = $this->whois->lookup ($this->params['domain']);
		$this->request->setResponse ($data);

		return TRUE;
	}

	/*
	*
	* @function: dig
	* Zwraca wynik komendy dig dla zadanych parametrów.
	*
	*/

	public function dig () {

		$this->load->model ('dig');

		$data = $this->dig->makeDig ($this->params);

		if ($data) {
			$this->request->setResponse ($data);
			return TRUE;
		}

		return FALSE;
	}

	/*
	*
	* @function: dropper_stats
	* Zwraca dostępne rozszerzenia i liczbę domen w bazie per rozszerzenie.
	*
	*/

	public function dropper_stats () {

		$this->load->model ('dropper');

		$data = $this->dropper->makeStats (isset ($this->params['extension']) ? $this->params['extension'] : false;

		if ($data) {
			$this->request->setResponse ($data);
			return TRUE;
		}

		return FALSE;
	}

}
