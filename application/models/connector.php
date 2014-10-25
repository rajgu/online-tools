<?php

	/*
	*
	* @model: connector
	* Model do wysyłania zapytań do zewnętrznych stron / serwerów.
	*
	*/

class Connector extends CI_Model {

	/*
	*
	* @var: _maxredirs
	* Zmienna określająca maksymalną liczbę przekierowań.
	*
	*/

	private $_maxredirs = 5;

	/*
	*
	* @var: _requesttimeresolution
	* Ilość czasu (milisekundy), co który sprawdzamy czy wszystkie wątki curla się skończyły.
	*
	*/

	private $_requesttimeresolution = 200;

	/*
	*
	* @var: _referer
	* Zmienna określająca domyślnego referera dla zapytania.
	*
	*/

	private $_referer = 'http://www.google.com';

	/*
	*
	* @var: _useragent
	* Zmienna określająca jak przedstawia się skrypt na zewnątrz.
	*
	*/

	private $_useragent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safari/537.36';

	/*
	*
	* @var: _handler
	* Uchwyt do curla, inicjowany w konstruktorze.
	*
	*/

	private $_handler = FALSE;

	/*
	*
	* @array: _tasks
	* Tablica przechowująca informację o zadaniach.
	*
	*/

	private $_tasks = array ();

	/*
	*
	* @function: __construct
	* Konstruktor, inicjuje uchwyt do curl_multi_init.
	*
	*/

	public function __construct () {

		$this->_initCurl ();
	}

	/*
	*
	* @function: get
	* Pobiera informację o stronie za pośrednictwem funkcji GET.
	*
	*/

	public function get ($link = FALSE, $timeout = 10) {

		if (! $timeout OR ! is_numeric ($timeout)) {
			$this->logger->syntax (array ('Nieprawidlowy parametr wejsciowy timeout ', $timeout));
			return false;
		}

		if (is_array ($link)) {
			foreach ($link as $ll) {
				if (! $ll OR ! is_string ($ll)) {
					$this->logger->syntax (array ('Nieprawidlowy parametr wejsciowy tablicy link ', count ($link), $ll));
					return false;
				}
			}
		} else {
			if (! $link OR ! is_string ($link)) {
				$this->logger->syntax (array ('Nieprawidlowy parametr wejsciowy link ', $link));
				return false;
			}
			$link = array (0 => $link);
		}

		// Po zweryfikowaniu parametrów wejściowych - przechodzimy do właściwego pobierania danych.
		// 1. Dodajemy zlecenia.
		foreach ($link AS $id => $url) {

			$this->_tasks[$id] = array (
				'url'		=> $url,
				'handler'	=> curl_init (),
			);

			curl_setopt ($this->_tasks[$id]['handler'], CURLOPT_URL, $this->_tasks[$id]['url']);
			curl_setopt ($this->_tasks[$id]['handler'], CURLOPT_RETURNTRANSFER, TRUE);
			if ($this->_maxredirs) {
				curl_setopt ($this->_tasks[$id]['handler'], CURLOPT_AUTOREFERER, TRUE);
				curl_setopt ($this->_tasks[$id]['handler'], CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt ($this->_tasks[$id]['handler'], CURLOPT_MAXREDIRS, $this->_maxredirs);
			}
			curl_setopt ($this->_tasks[$id]['handler'], CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt ($this->_tasks[$id]['handler'], CURLOPT_REFERER, $this->_referer);
			curl_setopt ($this->_tasks[$id]['handler'], CURLOPT_USERAGENT, $this->_useragent);

			curl_multi_add_handle ($this->_handler, $this->_tasks[$id]['handler']);
		}

		// 2. Czekamy na zakończenie wszystkich pobierań.
		$running = 0;
		$start = time ();
		curl_multi_exec ($this->_handler, $running);
		do {
			if (time () > ($start + $timeout)) {
				$this->logger->fatal (array ('Przekroczenie czasu zadan, Running: ', $running, ' Timeout: ', $timeout, ' Tasks: ', $this->_tasks));
				return false;
			}
			usleep ($this->_requesttimeresolution);
			curl_multi_exec ($this->_handler, $running);
		} while ($running > 0);

		// 3. Pobieramy, weryfikujemy i zwracamy co nam curl pobrał.
		$return = array ();
		foreach ($this->_tasks as $id => $data) {

			$return[$id] = curl_multi_getcontent ($this->_tasks[$id]['handler']);
			if (! $return[$id] OR empty ($return[$id]))
				$this->logger->warning (array ('Zadanie: ', $this->_tasks[$id]['url'], ' nie zwrocilo danych'));

			curl_multi_remove_handle ($this->_handler, $this->_tasks[$id]['handler']);
		}

		$this->_initCurl ();
		$this->_tasks = array ();

		return (count ($return) == 1) ? $return[0] : $return;
	}

	/*
	*
	* @function: _initCurl
	* Funkcja inicjuje wywołanie curl_multi_init.
	*
	*/

	private function _initCurl () {

		if ($this->_handler)
			curl_multi_close ($this->_handler);

		$this->_handler = curl_multi_init ();

		if (! $this->_handler) {
			$this->logger->fatal ('Nie udalo sie zainicjowac obiektu curl_multi_init');
			return false;
		}

		return true;
	}

}
