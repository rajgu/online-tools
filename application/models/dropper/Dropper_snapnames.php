<?php

Class Dropper_snapnames extends CI_Model {

	/*
	*
	* @param: PARSE_REG
	* Wyrażenie regularne, według którego parsowane są rekordy.
	*
	*/
	
	protected $PARSE_REG = '/^([\w-]+)\.([\.\w]+)\s+([\d]+)*\s+([\d\/]+\s+[\d:]+)\s*$/';

	/*
	*
	* @param: SNAPNAMES_URL
	* Adres, pod którym nask publikuje usunięte domeny do pobrania ze strony snapnames.
	*
	*/
	
	protected $SNAPNAMES_URL = 'https://www.snapnames.com/file_dl.sn?file=snppreorderstarting{DAY}.zip';

	/*
	*
	* @param: SNAPNAMES_FILES_ARRAY
	* Tablica przechowująca informacje o ściągniętych plikach w uruchomionej instancji.
	*
	*/
	
	protected $SNAPNAMES_FILES_ARRAY = array ();

	/*
	*
	* @function: __construct
	* Domyślny konstruktor.
	*
	*/

	public function __construct () {

		return true;
	}

	/*
	*
	* @function: __parse
	* Funkcja ściąga plik ze strony snapnames, zapisuje w katalogu tymczasowym i uzupełnia lokalną tablicę z nazwami plików.
	*
	*/

	protected function __parse ($extension, $days = 1) {

		$errors = false;

		$handle = fopen ($this->SNAPNAMES_FILES_ARRAY[$days]['efile'], "r");
		if ($handle) {

		    while (($line = fgets ($handle)) !== false) {
		        preg_match ($this->PARSE_REG, $line , $matches);

				if (isset ($matches[1]) AND isset ($matches[2]) AND isset ($matches[4])) {

					if (! isset ($this->SNAPNAMES_FILES_ARRAY[$days]['data'][$matches[2]]))
						$this->SNAPNAMES_FILES_ARRAY[$days]['data'][$matches[2]] = array ();

					if ($matches[2] == $extension) {
						$this->SNAPNAMES_FILES_ARRAY[$days]['data'][$matches[2]][] = array (
							'name' => $matches[1] . "." . $matches[2],
							'date' => $matches[4],
						);						
					}

				} else {
					$this->logger->fatal (array ('Cant parse record: "', $line, '"'));
					$errors = true;
					continue;
				}
		    }

		    fclose ($handle);
		
		}
	}

	/*
	*
	* @function: __get
	* Funkcja pobiera zwraca domeny zapisane w strukturze po sparsowaniu.
	*
	*/

	public function __getDomains ($extension, $days = 1) {

		if (! isset ($this->SNAPNAMES_FILES_ARRAY[$days]['data'][$extension]))
			return false;

		return $this->SNAPNAMES_FILES_ARRAY[$days]['data'][$extension];
	}

	/*
	*
	* @function: __download
	* Funkcja ściąga plik ze strony snapnames, zapisuje w katalogu tymczasowym i uzupełnia lokalną tablicę z nazwami plików.
	*
	*/

	protected function __download ($extension, $days = 1) {

		if (isset ($this->SNAPNAMES_FILES_ARRAY[$days]))
			return true;

		$url = strtr ($this->SNAPNAMES_URL, array ('{DAY}' => $days));
		$fname = FCPATH . "tmp/snapnames${days}.zip";
		$edir = strtr ($fname, array ('.zip' => '')); 
		$efile = $edir . strtr ("/snppreorderstarting{DAY}.txt", array ('{DAY}' => $days));

		$content = file_get_contents ($url);

		if (! $content) {
			$this->logger->fatal (array ('Failed to download file": ', $url));
			return false;
		}

		if (! file_put_contents ($fname, $content)) {
			$this->logger->fatal (array ('Failed to save file: ', $fname));
			return false;			
		}

		$zip = new ZipArchive;
		$res = $zip->open ($fname);

		if ($res === true) {
			$zip->extractTo ($edir);
			$zip->close ();

			if (! file_exists ($efile)) {
				$this->logger->fatal (array ('Extracted file: '. $efile, ' does not exists'));
				return false;
			}

			$this->SNAPNAMES_FILES_ARRAY[$days] = array (
				'url'   => $url,
				'fname' => $fname,
				'edir'  => $edir,
				'efile' => $efile,
				'data'  => array (),
			);

			$this->__parse ($extension, $days);

			return true;

		} else {

			$this->logger->fatal (array ('Failed to unpack file: ', $fname, ' to: ', $edir));
			return false;
		}


	}

}