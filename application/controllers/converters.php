<?php

/*
*
* @controller: Converters
* Funkcje związane z konwersją między formatami.
*
*/

class Converters extends CI_Controller {

    /*
    *
    * @function: base64
    * Kontroler akcji do dekodowania/enkodowania z/do Base64.
    *
    */

    public function base64 () {

        $params = array (
            'js'    => array (
                'cryptojs' => 'core,encoders',
            ),
        );

        $this->load->view ('head', $this->viewer->getHeaderData ($params));
        $this->load->view ('converters/base64');
        $this->load->view ('footer');
    }

}
