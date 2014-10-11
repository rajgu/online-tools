<?php

class Api extends CI_Controller {

	/*
	*
	* @function: index
	* Funkcja przetwarza wszelkie żądania do API.
	* Sprawdza limity ilości zapytań do API w określonym czasie, jeżeli zostaną przekroczone
	* zwracamy użytkownikowi captche do wprowadzenia.
	* 
	*/

	public function index () {

		$this->load->model (array ('logger', 'limitter', 'request', 'response'));
		$this->logger->debug (array ('Nowe zadanie: ', $this->request->getRaw ()));

		if ($captcha = $this->request->getField ('captcha')) {
			$this->load->model ('captcha');
			if ($this->captcha->validate ($captcha))
				$this->limitter->reset ();
		}

		if ($this->limitter->checkLimit ()) {

			if (! $this->limitter->update ()) {
				$this->log->fatal ('Nie udalo sie zaktualizowac limitu wywolan');
				$this->response->fail ('Internal Database Error.');
			}

			if (! $this->request->pre_process ()) {
				$this->log->fatal (array ('Bledne zadanie: ', $this->request->getReason ()));
				$this->response->fail ('Bad Request.');
			}

			if (! $this->request->process ()) {
				$this->log->fatal (array ('Nie udalo sie przetworzyc zadania: ', $this->request->getReason ()));
				$this->response->fail ('Internal Error.');
			}

			$this->logger->info (array ('Zadanie OK Typ: ', $this->request->getModel (), ' Funkcja: ', $this->Request->getFunction ()));
			$this->response->success ($this->request->getResponse ());

		} else {

			if (! $captcha = $this->captcha->makeNew ()) {
				$this->logger->fatal (array ('Nie udalo sie stworzyc captchy: ', $this->captcha->getReason ()));
				$this->response->fail ('Internal Error');
			}

			$this->response->captcha ($this->request->getAll (), $captcha);
		}
	}

}
