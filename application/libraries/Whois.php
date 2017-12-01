<?php

/*
*
* @library: Whois
* Obsługa zewnętrznego modułu phpwhois.
*
*/

class Whois {

	/*
	*
	* @function: Whois
	* Domyślny konstruktot, ładuje zewnętrzną klasę, oraz tworzy główny obiekt.
	*
	*/

	public function __construct () {

		require_once (APPPATH . 'third_party/phpwhois/whois.main.php');

		$this->_whois = new PHPWhois ();
	}

	/*
	*
	* @function: lookup
	* Wrapper na wywołanie PHPWhois->Lookup ().
	*
	*/

	public function lookup ($params) {

		return $this->_whois->Lookup ($params);
	}

}
