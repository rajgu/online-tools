<?php

/*
*
* @controller: Encryption
* Funkcje związane z hashowanie, szyframi blokowymi itp...
*
*/

class Encryption extends CI_Controller {


	/*
	*
	* @function: hash
	* Kontroler akcji do hashowania
	*
	*/

	public function hash () {

		$params = array (
			'js'	=> array (
				'cryptojs'	=> 'core,hash_functions',
			),

		);

		$this->load->view ('head', $this->viewer->getHeaderData ($params));
//		$this->load->view ('encryptions/hash');

	}

}
