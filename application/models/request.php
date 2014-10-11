<?php

	/*
	*
	* @model Request
	* Klasa do obsługi żądania api.
	* Sprawdza parametry wejściowe, ładuje, oraz uruchamia wybrane moduły.
	*
	*/

class Request extends CI_Model {

	private $_inputData = array ();

	/*
	*
	* @function: __construct
	* Pobiera dane parsowane z $_POST.
	*
	*/

	public function __construct () {

		$data = $this->input->post ('data');
		if (! $data OR ! $data = json_decode ($data))
			$this->logger->warning ('Niepoprawne dane wejsciowe');
		$this->_inputData = $data;
	}

	/*
	*
	* @function: getField
	* Getter dla dowolnego pola z wysłanego żądania.
	*
	*/

	public function getField ($field) {

		if (isset ($this->_inputData[$field]))
			return $this->_inputData[$field];
		return FALSE;
	}

	/*
	*
	* @function: getRaw
	* Zwraca oryginalne dane przesłane w wywołaniu.
	*
	*/

	public function getRaw () {

		return $_POST;
	}

}
