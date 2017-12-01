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


		$this->load->model ('connector');
		$this->load->model ('dropper/dropper_pl');

		$data = $this->dropper_pl->getDroppedDomains ();
		var_dump ($data);


	}


}
