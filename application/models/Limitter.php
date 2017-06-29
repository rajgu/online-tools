<?php

	/*
	*
	* @model: Limitter
	* Klasa do logowania oraz weryfikowania limitów zapytań do api.
	*
	*/

class Limitter extends CI_Model {

	/*
	*
	* @function: checkLimit
	* Funkcja sprawdza czy z zadanego ip wykorzystno juz limit zapytan dla danej jednostki czasu:
	* 1 minuta - maksymalnie 'request_limit_min'.
	* 1 godzina - maksymalnie 'request_limit_hour'.
	*
	*/

	public function checkLimit ($ip = FALSE) {

		if (! $ip)
			$ip = $this->input->ip_address ();

		$ip = ip2long ($ip);

		$num = $this->_getNumRequests ($ip);

		// w przypadku bledow pobierania informacji z bazy zachowujemy sie jakby limit zostal osiagniety
		if (! is_array ($num))
			return FALSE;

		if (
			$num['min']  >= $this->config->item ('request_limit_min') OR
			$num['hour'] >= $this->config->item ('request_limit_hour')
		) return FALSE;

		return TRUE;
	}

	/*
	*
	* @function: addEntry
	* Funkcja dodaje pozycje odpytania do API.
	*
	*/

	public function addEntry ($ip = FALSE) {

		if (! $ip)
			$ip = $this->input->ip_address ();

		$ip   = ip2long ($ip);
		$time = time ();

		$this->db->insert ('limitter', array ('ip' => $ip, 'timestamp' => $time));

		$result = ($this->db->affected_rows () != 1) ? FALSE : TRUE;

		if (! $result)
			$this->logger->warning (array ("Nie udalo sie dodac pozycji limitera ip: $ip time: $time", $this->db->error ()));

		return $result;
	}

	/*
	*
	* @function: clearUserEntries
	* Funkcja zleca kasowanie wpisow dla zadanego adresu ip.
	*
	*/

	public function clearUserEntries ($ip = FALSE) {

		if (! $ip)
			$ip = $this->input->ip_address ();

		$ip = ip2long ($ip);

		return $this->_deleteEntries (array ('ip' => $ip));
	}

	/*
	*
	* @function: clearOldEntries
	* Funkcja zleca kasowanie wpisow starszych niż godzina.
	*
	*/

	public function clearOldEntries () {

		return $this->_deleteEntries (array ('timestamp' => time () - 60 * 60));
	}

	/*
	*
	* @function: deleteEntries
	* Fukcja kasuje wpisy wedle zadanych kryteriow:
	* adres ip oraz timestamp.
	*
	*/

	private function _deleteEntries ($params = array ()) {

		if (! is_array ($params)) {
			$this->logger->syntax ('Nie poprawny parametr wejsciowy: $param');
			return FALSE;
		}

		$where = '1';

		if (isset ($params['ip']))
			$where .= " AND `ip` = {$params['ip']}";
		if (isset ($params['timestamp']))
			$where .= " AND `timestamp` <= {$params['timestamp']}";

		$this->db->simple_query ("DELETE FROM `limitter` WHERE $where");

		$rows = $this->db->affected_rows();

		if ($rows > 0) {
			$this->logger->info (array ("Skasowalem $rows rekordow dla parametrow ", $params));
			return TRUE;
		}

		$this->logger->warning (array ("Nie skasowalem zadnego rekordu dla parametrow ", $params));
		return FALSE;
	}

	/*
	*
	* @function: _getNumRequests
	* Funkcja pobiera ilość zapytań do api w limitowanych okresach czasu:
	* 1 minuta oraz 1 godzina.
	*
	*/

	private function _getNumRequests ($ip) {

		$data = array ();
		$time = time ();
		$sql  = "SELECT count(*) AS `count` FROM `limitter` WHERE `ip` = ? AND `timestamp` >= ? ";

		$result = $this->db->query ($sql, array ($ip, $time - 60));
		if ($this->db->error ()['code'] !== 0) {
			$this->logger->warning (array ('Nie udalo sie pobrac danych limitera (min) ', $this->db->error ()));
			return FALSE;
		}

		$data['min'] = (int) $result->row ()->count;

		$result = $this->db->query ($sql, array ($ip, $time - 60 * 60));
		if ($this->db->error()['code'] !== 0) {
			$this->logger->warning (array ('Nie udalo sie pobrac danych limitera (hour) ', $this->db->error ()));
			return FALSE;
		}

		$data['hour'] = (int) $result->row ()->count;

		return $data;
	}

}
