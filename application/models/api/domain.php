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

		$this->load->library ('whois');

		$data = $this->whois->lookup ($this->params);
		$this->request->setResponse ($data);
		return TRUE;
	}

}
