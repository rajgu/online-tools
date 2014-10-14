<?php if (! defined ('BASEPATH')) exit ('No direct script access allowed');

/*
*
* @controller: main
* Kontroler odpowiedzialny za stronę główną.
*
*/


class Main extends CI_Controller {

	/*
	*
	* @function: index
	* Głowna akcja.
	*
	*/

	public function index ()
	{
		$this->load->view ('head');
	}
}
