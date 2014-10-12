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
			$this->logger->syntax ('Niepoprawne dane wejsciowe');
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

	/*
	*
	* @function: pre_process
	* Funkcja sprawdza czy istnieje klasa oraz metoda do przetworzenia zadania.
	*
	*/

	public function pre_process () {

		$model   = $this->getField ('type');
		$command = $this->getField ('command');

		if (! file_exists (APPPATH . "models/{$model}.php")) {
			$this->logger->syntax ("Model $model nie istnieje");
			return FALSE;
		}

		$this->load->model ($type);

		if (! method_exists ($this->$type, $command)) {
			$this->logger->syntax ("Metoda: $command w modelu $model nie istnieje");
			return FALSE;
		}

		return TRUE;
	}

}
