<?php

/*
*
* @model dropper_koeln
* Klasa do obsługi pobierania usuniętych domen .koeln.
*
*/

class Dropper_koeln extends Dropper_Snapnames {
	
	/*
	*
	* @param: EXTENSION
	* Rozszerzenie domeny, którą pobieramy
	*
	*/
	
	private $EXTENSION = 'koeln';

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
	* Funkcja pobiera usunięte domeny .com
	*
	*/

	public function getDroppedDomains () {

		if (! $this->__download ($this->EXTENSION))
			return false;

		$domains = $this->__getDomains ($this->EXTENSION);

		if (! $domains) {

			$this->logger->fatal (array ('nie udalo sie pobrac listy domen dla rozszerzenia: ', $this->EXTENSION));
			return false;
		} else {

			$this->logger->info (array ('udalo sie pobrac listy domen dla rozszerzenia: ', $this->EXTENSION));
			return $domains;
		}
	}


}