<?php

class Network extends CI_Model {

	public function __construct () {

		$this->params = $this->request->getParams ();
	}
	
	public function ping () {

		$this->logger->info (array ('ping', $this->params));

		$this->request->SetResponse ('Test');

		return TRUE;
	}
}