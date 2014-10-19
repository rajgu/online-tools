<?php

/*
*
* @model: checks
* Różnorakie funkcje do sprawdzania poprawności wprowadzanych danych.
*
*/

class Checks extends CI_Model {
	
	/*
	*
	* @function: domainName
	* Sprawdza czy dany ciąg znaków jest poprawną nazwą domeny.
	*
	*/

	public function domainName ($domain) {

		return (
			preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain) AND
			preg_match("/^.{1,253}$/", $domain) AND
			preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain)
		);
	}

}
