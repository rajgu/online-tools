<?php

/*
*
* @model: dig
* Klasa do obsługi zewnętrznego narzędzia 'dig'.
*
*/

class Dig extends CI_Model {

	/*
	*
	* @array: _digTypes
	* Tablica z typami zapytań wraz z opisami.
	*
	*/

	private $_digTypes = array (
		'ANY'	=> 'Any Type',
		'A'		=> 'IPv4 Address',
		'AAAA'	=> 'IPv6 Adress',
		'CNAME'	=> 'Canonical Name',
		'NS'	=> 'Name Servers',
		'MX'	=> 'Mail Exchange',
		'PTR'	=> 'Domain Pointer',
		'SOA'	=> 'Start Of Authority',
		'TXT'	=> 'Text',  
		'LOC'	=> 'Location',
		'RP'	=> 'Responsible Person',
		'AXFR'	=> 'Zone Transfer',
	);

	/*
	*
	* @array: _queryProtocols
	* Tablica z protokołami, wykorzystywanymi do transportu.
	*
	*/

	private $_digProtocols = array (
		0	=> 'Default',
		4	=> 'IPv4',
		6	=> 'IPv6',
	);

	/*
	*
	* @function: getDigTypes
	* Zwraca tablicę z typami i nazwami rekordów o które możemy odpytać.
	*
	*/

	public function getDigTypes () {

		return $this->_digTypes;
	}

	/*
	*
	* @function: getDigProtocols
	* Zwraca obsługiwane protokoły transportowe.
	*
	*/

	public function getDigProtocols () {

		return $this->_digProtocols;
	}

	/*
	*
	* @function: makeDig
	* Funkcja składa zapytania na podstawie podanych kryteriów.
	* *domain - nazwa odpytywanej domeny.
	* *type - o jaki typ rekordów odpytujemy.
	* *host [opt] - serwer, który odpytujemy.
	* *transport [opt] - protokół, którym odpytujemy.
	*
	*/

	public function makeDig ($params = array ()) {

		$command = 'dig';

		if (! isset ($params['domain']) OR ! $this->checks->domainName ($params['domain'])) {
			$this->logger->syntax (array ('Bad dig domain ', $params));
			return FALSE;
		}
		$command .= " {$params['domain']}";

		if (! isset ($params['type']) OR ! isset ($this->_digTypes[$params['type']])) {
			$this->logger->syntax (array ('Bad dig type ', $params));
			return FALSE;
		}
		$command .= " -t {$params['type']}";

		if (isset ($params['transport']) AND ! in_array ($params['transport'], array (0, FALSE))) {
			if (isset ($this->_digProtocols[$params['transport']])) {
				$command .= "-{$params['transport']}";
			} else {
				$this->logger->syntax (array ('Bad dig transport ', $params));
				return FALSE;
			}
		}

		if (isset ($params['host'])) {
			if ($this->checks->domainName ($params['host'])) {
				$command .= " @{$params['host']}";
			} else {
				$this->logger->syntax (array ('Bad dig host ', $params));
				return FALSE;
			}
		}

		exec ($command, $output);

		if (empty ($output))
			return FALSE;

		return $this->_parseResponse ($output);
	}

	/*
	*
	* @function: _parseResponse
	* Parsowałka z domyślnego formatu zwracanego przez DIG-a do formy tablicy asocjacyjnej.
	*
	*/	

	private function _parseResponse ($data) {

		return $data;
	}

}
