<?php

/*
*
* @config: variables
* dodatkowy plik konfiguracyjny.
*
*/

$config = array (
	'request_limit_min'		=> 20, // maksymalna liczba requestow bez captchy na minute
	'request_limit_hour'	=> 200, // maksymalna liczba requestow bez captchy na godzine

	// Definicja plików dołączanych na produkcji i developerce
	'includes'	=> array (
		'production'	=> array (
			'css'	=> array (
				'bootstrap.min.css',
				'bootstrap-theme.min.css',
			),
			'js'	=> array (
				'jquery-2.1.1.min.js',
				'bootstrap.min.js',
			),
			'js_ie8'=> array (
				'html5shiv.js',
				'respond.min.js',
			),
		),
		'development'	=> array (
			'css'	=> array (
				'bootstrap.min.css',
				'bootstrap-theme.min.css',
			),
			'js'	=> array (
				'jquery-2.1.1.min.js',
				'bootstrap.min.js',
			),
			'js_ie8'=> array (
				'html5shiv.js',
				'respond.min.js',
			),
		),
	),
);