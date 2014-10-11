<?php

	/*
	*
	* @model Request
	* Klasa do obsługi żądania api.
	* Sprawdza parametry wejściowe, ładuje, oraz uruchamia wybrane moduły.
	*
	*/

class Request extends CI_Model {

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
