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

    /*
    *
    * @function: traceroute
    * Kontroler akcji do śledzenia ścieżki.
    *
    */

    public function traceroute () {

        $this->load->view ('head', $this->viewer->getHeaderData ());
        $this->load->view ('network/traceroute');
        $this->load->view ('footer');


        $this->load->model ('IpLocation');
        echo "<br><br><br>";
        var_dump ($this->IpLocation->locate ('2602:302:9eb4:8fff:ffff:ffff:ffff:ffff'));

    }
}
