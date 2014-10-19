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
				'//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css',
				'//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css',
			),
			'js'	=> array (
				'//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
				'//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js',
			),
			'js_ie8'=> array (
				'/public/js/html5shiv.js',
				'/public/js/respond.min.js',
			),
		),
		'development'	=> array (
			'css'	=> array (
				'/public/css/bootstrap.min.css',
				'/public/css/bootstrap-theme.min.css',
			),
			'js'	=> array (
				'/public/js/jquery-2.1.1.min.js',
				'/public/js/bootstrap.min.js',
			),
			'js_ie8'=> array (
				'/public/js/html5shiv.js',
				'/public/js/respond.min.js',
			),
		),
	),

);
