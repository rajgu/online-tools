<?php

Class Dropper_snapnames extends CI_Model {

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
	* @function: __download
	* Funkcja ściąga plik ze strony snapnames, zapisuje w katalogu tymczasowym i uzupelnia lokalną tablicę z nazwami plików.
	*
	*/

	protected function __download ($days = 1) {

		$url = strtr ($this->SNAPNAMES_URL, array ('{DAY}' => $days));
		$fname = FCPATH . "tmp/snapnames${days}.zip";
		$edir = strtr ($fname, array ('.zip' => '')); 
		$efile = $edir . strtr ("/snppreorderstarting{DAY}", array ('{DAY}' => $days));

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

			$this->SNAPNAMES_FILES_ARRAY[$days] = array ()


		} else {

			$this->logger->fatal (array ('Failed to unpack file: ', $fname, ' to: ', $edir));
			return false;
		}


	}

}