<?php

class Network extends CI_Model {

	public function __construct () {

		$this->params = $this->request->getParams ();
	}

    /**
    *
    * @method: ping
    * Metoda wywołuje metode ping dla danego adresu.
    * @params:
    * host - Adres do sprawdzenia
    * count - Ile żdań mam wysłać
    * ttl - Ilośc hopów dla pojedyńczego żądania
    *
    */
	
	public function ping () {

        $this->load->model ('ip');

        if (!isset ($this->params['host']) OR !$this->params['host'] ) {
            $this->logger->syntax ('Brak wymaganego parametru: "host"');
            return false;
        }

        if (!isset ($this->params['ttl']) OR
            !$this->params['ttl'] OR
            !is_numeric ($this->params['ttl']) OR
            $this->params['ttl'] < $this->config->item ('ping')['ttl']['range_from']  OR
            $this->params['ttl'] > $this->config->item ('ping')['ttl']['range_to']) {

            $this->logger->syntax (array ('Nieprawidlowy parametr `ttl`, ustawiam domyślny'));

            $this->params['ttl'] = $this->config->item ('ping')['ttl']['default'];
        }

        if (!isset ($this->params['count']) OR
            !$this->params['count'] OR
            !is_numeric ($this->params['count']) OR
            $this->params['count'] < $this->config->item ('ping')['count']['range_from']  OR
            $this->params['count'] > $this->config->item ('ping')['count']['range_to']) {

            $this->logger->syntax (array ('Nieprawidlowy parametr `count`, ustawiam domyślny'));

            $this->params['count'] = $this->config->item ('ping')['count']['default'];
        }

        if (!$this->ip->isIpv4 ($this->params['host']) AND
            !$this->ip->isIpv6 ($this->params['host']) AND
            !$this->ip->isHostname ($this->params['host'])) {

            $this->logger->syntax (array ('Nieprawidłowy parametr host: ', $this->params['host']));
            return false;
        }

        $response = $this->ip->ping ($this->params);
        $this->request->SetResponse ($response ? $response : 'false');

        return true;

	}

    /**
    *
    * @method: locate
    * Metoda zwraca region przypisany do danego hosta / ip.
    * @params:
    * input - Adres do sprawdzenia
    *
    */

    public function locate () {

        if (! isset ($this->params['input']) OR !$this->params['input']) {
            $this->logger->syntax ('Brak wymaganego parametru: "input"');
            return false;
        }

        $this->load->model ('ip');
        $response = $this->ip->locate ($this->params['input']);
        $this->request->SetResponse ($response ? $response : 'false');

        return true;
    }


}