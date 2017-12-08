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
	* Kontroler akcji domains->whois
	*
	*/

	public function whois () {

		$this->load->view ('head', $this->viewer->getHeaderData ());
		$this->load->view ('domains/whois');

	}

	/*
	*
	* @function: dropped
	* Kontroler akcji domains->dropped
	*
	*/

	public function dropped () {

		$this->load->view ('head', $this->viewer->getHeaderData ());
		$this->load->view ('domains/dropped');

		$this->load->model ('dropper');
		$this->dropper->process ();

//		var_dump ($this->dropper->makeStats ());


//		var_dump ($this->dropper->getDomains (false, false, 'z'));


		
	}


}
