<?php

/*
*
* @model: viewer
* Klasa generująca dane przekazywane do elementów widoku.
*
*/

class Viewer extends CI_Model {

	/*
	*
	* @function: getHeaderData
	* Zwraca dane meta/title/includy.
	*
	*/

	public function getHeaderData () {

		$includes = $this->config->item ('includes');

		return array (
			'title'		=> 'Typical Title',
			'keywords'	=> 'typical keywords',
			'css'		=> $this->_makeURL ($includes[ENVIRONMENT]['css']),
			'js'		=> $this->_makeURL ($includes[ENVIRONMENT]['js']),
			'js_ie8'	=> $this->_makeURL ($includes[ENVIRONMENT]['js_ie8']),
		);
	}

	/*
	*
	* @function: _makeURL
	* Funkcja dodaje do lokalnych nazw plików przedrostek bazowego URL.
	*
	*/

	private function _makeURL ($url) {

		if (is_array ($url))
			return array_map (array ($this, '_switchLink'), $url);

		return $this->_switchLink ($url);
	}

	/*
	*
	* @function: _switchLink
	* Funkcja wywołuje base_url () na lokalnych nazwach plików.
	*
	*/

	private function _switchLink ($link) {

		if (substr ($link, 0, 2) != '//')
			return base_url ($link);

		return $link;
	}

}
