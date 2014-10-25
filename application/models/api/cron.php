<?php

/*
*
* @model: domain
* Obsługa wywołań api dla cron-ów.
*
*/

class Cron extends CI_Model {

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
	* @function: getDropped
	* Wywołuje akcje pobierania dropowanych domen.
	*
	*/

	public function getDropped () {

		$this->load->model ('connector');
		$this->load->model ('dropper');

		$this->dropper->process ();

		return TRUE;
	}
}

