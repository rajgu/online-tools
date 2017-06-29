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

		if (! $this->request->pre_process ()) {
			$this->logger->fatal ('Bledne zadanie');
			$this->response->fail ('Bad Request.');
			return;
		}

		if ($captcha = $this->request->getCaptcha ('captcha')) {
			$this->load->model ('captcha');
			if ($this->captcha->validate ($captcha))
				$this->limitter->clearUserEntries ();
		}

		if ($this->limitter->checkLimit ()) {

			if (! $this->limitter->addEntry ()) {
				$this->logger->fatal ('Nie udalo sie zaktualizowac limitu wywolan');
				$this->response->fail ('Internal Database Error.');
				return;
			}


			if (! $this->request->process ()) {
				$this->logger->fatal ('Nie udalo sie przetworzyc zadania');
				$this->response->fail ('Internal Error.');
				return;
			} else {
				$this->logger->info (array ('Zadanie OK Typ: ', $this->request->getModel (), ' Funkcja: ', $this->request->getMethod ()));
				$this->response->success ($this->request->getResponse ());
			}

		} else {

			if (! $captcha = $this->captcha->makeNew ()) {
				$this->logger->fatal (array ('Nie udalo sie stworzyc captchy: ', $this->captcha->getReason ()));
				$this->response->fail ('Internal Error');
			}

			$this->response->captcha ($this->request->getAll (), $captcha);
		}
	}

}
