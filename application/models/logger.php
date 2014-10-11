<?php

	/*
	*
	* @model: Logger
	* Klasa do zapisywania logów
	*
	*/

class Logger extends CI_Model {

	/*
	*
	* @function: info
	* Zapisuje log o poziomie info
	*
	*/

	public function info ($log) {
		return $this->logEvent ($log, 'INFO');
	}

	/*
	*
	* @function: debug
	* Zapisuje log o poziomie debug, tylko w przypadku, gdy ustawiony jest tryb development
	*
	*/

	public function debug ($log) {
		if (ENVIRONMENT == 'development')
			return $this->logEvent ($log, 'DEBUG');
	}

	/*
	*
	* @function: warning
	* Zapisuje log o poziomie warning
	*
	*/

	public function warning ($log) {
		return $this->logEvent ($log, 'WARNING');
	}

	/*
	*
	* @function: fatal
	* Zapisuje log o poziomie fatal
	*
	*/

	public function fatal ($log) {
		return $this->logEvent ($log, 'FATAL');
	}

	/*
	*
	* @function: logEvent
	* Fizyczny zapis logu do pliku
	*
	*/

	private function logEvent ($message, $level) {

		$ip    = $this->input->ip_address ();
		$file  = date ('d') . '.log';
		$dir   = date ('Y-m');
		$time  = date ('Y-m-d H:i:s');

		if (! file_exists ("logs/$dir"))
			mkdir ("logs/$dir", 0777);

		file_put_contents ("logs/$dir/$file", "$time - $ip - $level - $message\n", FILE_APPEND);
	}

}
