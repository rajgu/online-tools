<?php

/*
*
* @controller: domains
* Funkcje związane z domenami itp...
*
*/

class Domains extends CI_Controller {


	/*
	*
	* @function: whois
	* Kontroler akcji domains
	*
	*/

	public function whois () {

		$this->load->view ('head', $this->viewer->getHeaderData ());
		$this->load->view ('domains/whois');

	}

}
