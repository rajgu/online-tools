<?php

	/*
	*
	* @model: dropper
	* Moduł obsługujący pobieranie i kasowanie przez CRON-y listy dropowanych domen
	*
	*/

class Dropper extends CI_Model {

	/*
	*
	* @array: List_call
	* Lista rozszerzeń, wraz z callbackami do funckcji, które pobierają liste z zew. źródeł.
	*
	*/

	private $List_call = array (
		'de'	=> 'de_get',
	);

	/*
	*
	* @function: process
	* Główna funckja, pobiera liste rozszerzeń które mamy pobrać, wywołuje odpowiednie callbacki i zapisuje wyniki.
	*
	*/

	public function process () {

		$this->de_get ();
	}

	/*
	*
	* @function: de_get
	* Getter dla listy dropniętych domen de.
	* Zwraca pełną listę domen .de dla zadanego dnia, bądź false w przypadku błędu.
	*
	*/

	private function de_get () {

		// http://www.
		$page = $this->connector->get (array ("www.wp.pl", 'google.pl', 'onet.pl', 'wikipedia.org', 'online-tools.it'));
		print_r ($page);

	}

}

