<?php

	/*
	*
	* @model Request
	* Klasa do obsługi żądania api.
	* Sprawdza parametry wejściowe, ładuje, oraz uruchamia wybrane moduły.
	*
	*/

class Request extends CI_Model {

	private $_inputDataRaw = '';
	private $_inputData = array ();

	/*
	*
	* @function: __construct
	* Pobiera dane z php://input.
	*
	*/

	public function __construct () {

		$this->_inputDataRaw = file_get_contents ('php://input');
	}

	/*
	*
	* @function: getRaw
	* Zwraca oryginalne dane przesłane w wywołaniu.
	*
	*/

	public function getRaw () {

		return $this->_inputDataRaw;
	}

	/*
	*
	* @function: pre_process
	* Parsuje otrzymane dane oraz sprawdza czy istnieje klasa i metoda do przetworzenia zadania.
	*
	*/

	public function pre_process () {

		$this->_inputData = json_decode ($this->_inputDataRaw, TRUE);

		if (! $this->_inputData OR ! is_array ($this->_inputData)) {
			$this->logger->syntax ('bledne dane wejsciowe: ' . $this->_inputDataRaw);
			return FALSE;
		}

		$this->_model = $this->getField ('type');
		$this->_command = $this->getField ('command');

		if (! file_exists (APPPATH . "models/api/{$this->_model}.php")) {
			$this->logger->syntax ("model: {$this->_model} nie istnieje");
			return FALSE;
		}

		$this->load->model ("api/{$this->_model}");

		if (! method_exists ($this->{$this->_model}, $this->_command)) {
			$this->logger->syntax ("metoda: {$this->_command} w modelu: {$this->_model} nie istnieje");
			return FALSE;
		}

		return TRUE;
	}

	/*
	*
	* @function: process
	* Wywoluje odpowiednia metode wczesniej zaladowanego modelu.
	*
	*/

	public function process () {

		return $this->{$this->_model}->{$this->_command} ();
	}

	/*
	*
	* @function: getCaptcha
	* Sprawdza czy użytkownik wprowadzil captche i jezeli tak - zwraca jej wartosc.
	*
	*/

	public function getCaptcha () {

		return $this->getField ('captcha');
	}

	/*
	*
	* @function: getParams
	* Zwraca parametry zadania wprowadzone przez uzytkownika.
	*
	*/

	public function getParams () {

		return $this->getField ('params');
	}

	/*
	*
	* @function: getModel
	* Zwraca wywolany model.
	*
	*/

	public function getModel () {

		return isset ($this->_model) ? $this->_model : FALSE;
	}

	/*
	*
	* @function: getMethod
	* Zwraca wywolana metode.
	*
	*/

	public function getMethod () {

		return isset ($this->_command) ? $this->_command : FALSE;
	}

	/*
	*
	* @function: setResponse
	* Setter dla danych zwracanych przez metode api.
	*
	*/

	public function setResponse ($response = FALSE) {

		if (! $response) {
			$this->logger->syntax ('setting empty response data');
			return FALSE;
		}
		$this->_responseData = $response;

		return TRUE;
	}

	/*
	*
	* @function: getResponse
	* Getter dla danych zwracanych przez metode api.
	*
	*/

	public function getResponse () {

		if (! isset ($this->_responseData) OR ! $this->_responseData) {
			$this->logger->syntax ('getting from empty data');
			return FALSE;
		}

		return $this->_responseData;
	}




	/*
	*
	* @function: getField
	* Getter dla dowolnego pola z wysłanego żądania.
	*
	*/

	private function getField ($field) {

		if (isset ($this->_inputData[$field]))
			return $this->_inputData[$field];
		return FALSE;
	}

}
