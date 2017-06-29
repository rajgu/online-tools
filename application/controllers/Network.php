<?php

/*
*
* @controller: Network
* Funkcje związane z siecią.
*
*/

class Network extends CI_Controller {

    /*
    *
    * @function: ping
    * Kontroler akcji do wysyłania komunikatu kontrolnego ICMP.
    *
    */

    public function ping () {

        $this->load->view ('head', $this->viewer->getHeaderData ());
        $this->load->view ('network/ping');
        $this->load->view ('footer');
    }

}
