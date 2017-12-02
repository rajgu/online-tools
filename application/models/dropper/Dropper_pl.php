<?php

/*
*
* @model dropper_pl
* Klasa do obsługi pobierania usuniętych domen .pl.
*
*/

class Dropper_pl extends CI_Model {
	
	/*
	*
	* @param: NASK_URL
	* Adres, pod którym nask publikuje usunięte domeny .pl.
	*
	*/
	
	private $NASK_URL = 'https://www.dns.pl/deleted_domains.txt';

	/*
	*
	* @function: __parse
	* Funkcja parsuje listę domen do postaci tablicy.
	*
	*/

	private function __parse ($data) {

		$sliced = explode ("\n", $data);

		$date = $sliced[0];
		$domains = array ();
		$size = count ($sliced);
		for ($x = 2; $x < $size; $x++)
			$domains[] = $sliced[$x];


		return array (
			'date'		=> $date,
			'domains'	=> $domains,
		);
	}

	/*
	*
	* @function: __construct
	* Domyślny konstruktor.
	*
	*/

	public function __construct () {

		return true;
	}

	/*
	*
	* @function: getDroppedDomains
	* Funkcja pobiera usunięte domeny .pl
	*
	*/

	public function getDroppedDomains () {

		$data = $this->connector->get ($this->NASK_URL);

		return $data ? $this->__parse ($data) : false;
	}


}