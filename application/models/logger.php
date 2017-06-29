<?php

	/*
	*
	* @model: Logger
	* Klasa do zapisywania logów.
	*
	*/

class Logger extends CI_Model {

	/*
	*
	* @function: info
	* Zapisuje log o poziomie info.
	*
	*/

	public function info ($log) {
		return $this->_logEvent ($log, 'INFO');
	}

	/*
	*
	* @function: debug
	* Zapisuje log o poziomie debug, tylko w przypadku, gdy ustawiony jest tryb development.
	*
	*/

	public function debug ($log) {
		if (ENVIRONMENT == 'development')
			return $this->_logEvent ($log, 'DEBUG');
	}

	/*
	*
	* @function: warning
	* Zapisuje log o poziomie warning.
	*
	*/

	public function warning ($log) {
		return $this->_logEvent ($log, 'WARNING');
	}

	/*
	*
	* @function: syntax
	* Zapisuje log o poziomie syntax.
	*
	*/

	public function syntax ($log) {
		return $this->_logEvent ($log, 'SYNTAX');
	}

	/*
	*
	* @function: fatal
	* Zapisuje log o poziomie fatal.
	*
	*/

	public function fatal ($log) {
		return $this->_logEvent ($log, 'FATAL');
	}

	/*
	*
	* @function: _logEvent
	* Fizyczny zapis logu do pliku.
	*
	*/

	private function _logEvent ($message, $level) {

		$ip      = $this->input->ip_address ();
		$file    = date ('d') . '.log';
		$dir     = date ('Y-m');
		$time    = date ('Y-m-d H:i:s');
		$pid     = getmypid ();
		$message = $this->_createMessage ($message);
		$stacktrace	= $this->_getStackTrace (new Exception ());

		if (! file_exists ("logs/$dir"))
			mkdir ("logs/$dir", 0777);

		file_put_contents ("logs/$dir/$file", "$time $ip $pid $level $message $stacktrace\n", FILE_APPEND);
	}

	/*
	*
	* @function _createMessage
	* Funkcja Przerabia dane otrzymane w wiadmości na format możliwy do zapisania w pojedyńczej linii
	*
	*/

	private function _createMessage ($input) {

		$data = '';
		if (! is_array ($input)) {
			$data .= $this->_quoteLog ($input);
		} else {
			foreach ($input AS $key => $value)
				$data .= $this->_parseInput ($value);
		}

		return $data;
	}

	/*
	*
	* @function: _parseInput
	* Funkcja zwraca zserializowane, wyeskejpowane dane podane na wejściu.
	*
	*/

	private function _parseInput ($input) {

		$data = '';
		if (! is_array ($input)) {
			$data .= $this->_quoteLog ($input);
		} else {
			$data .= 'ARRAY => [';
			foreach ($input AS $key => $value)
				$data .= $this->_quoteLog ($key) . ' => ' . $this->_parseInput ($value);
			$data .= ']';
		}

		return $data;
	}

	/*
	*
	* @function: _quoteLog
	* Funkcja eskejpuje wszystkie znaki specjalne podane na wejsciu.
	*
	*/

	private function _quoteLog ($input) {
		return mysql_real_escape_string ($input);
	}

	/*
	*
	* @function: _getStackTrace
	* Zwraca stack trace wywoływanych funkcji.
	* Wycina funkcje loggera oraz CI.
	*
	*/

	private function _getStackTrace ($exception) {

		$dir		= getcwd ();
		$stack		= explode ("\n", $exception->getTraceAsString ());
		$stack		= array_slice ($stack, 1, count ($stack) - 4);
		$stack		= implode (', ', $stack);

		return (($dir == '/') ? $stack : str_replace ($dir, '', $stack));
	}

}
