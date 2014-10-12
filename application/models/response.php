<?php

	/*
	*
	* @model: Response
	* Klasa do wysyłania odpowiedzi zwrotnych do klienta.
	*
	*/

class Response extends CI_Model {

	/*
	*
	* @function: success
	* Drukuje komunikat typu success.
	*
	*/

	public function success ($message) {

		return $this->_printMessage ($message, 'success');
	}

	/*
	*
	* @function: warning
	* Drukuje komunikat typu warning.
	*
	*/

	public function warning ($message) {

		return $this->_printMessage ($message, 'warning');
	}

	/*
	*
	* @function: fail
	* Drukuje komunikat typu fail.
	*
	*/

	public function fail ($message) {

		return $this->_printMessage ($message, 'fail');
	}

	/*
	*
	* @function: _printMessage
	* Ustawia naglowki i drukuje komunikat.
	*
	*/

	private function _printMessage ($msg = FALSE, $type = FALSE) {

		if (! $msg OR ! $type) {
			$this->logger->syntax ("Brak parametru wejsciowego Message: {$msg} Type: {$type}");
		}

		$message = array ('status' => $type, 'message' => $msg);

		$this->output
			->set_content_type ('application/json')
			->set_output (json_encode ($message));

	}

}
