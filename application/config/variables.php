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

	// Dopuszczalne wartości dla ping - count i ttl
	'ping' => array (
		'count' => array ('range_from' => 1, 'range_to' =>  10, 'default' => 2),
		'ttl'   => array ('range_from' => 1, 'range_to' => 255, 'default' => 64),
	),

	// Definicja plików dołączanych na produkcji i developerce
	'includes'	=> array (
		'production'	=> array (
			'css'	=> array (
				'//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css',
				'//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css',
				'/public/css/custom.css',
			),
			'js'	=> array (
				'//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
				'//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js',
				'/public/js/bootstrap.file-input.js',
				'/public/js/spin.js',
				'/public/js/front.js',
			),
			'js_ie8'=> array (
				'/public/js/html5shiv.js',
				'/public/js/respond.min.js',
			),
			'cryptojs'	=> array (
				'core'			=> array (
					'/public/js/cryptojs/core-min.js',
					'/public/js/cryptojs/cipher-core-min.js',
					'/public/js/cryptojs/lib-typedarrays-min.js',
					'/public/js/cryptojs/x64-core-min.js',
				),
				'encoders'		=> array (
					'/public/js/cryptojs/enc-base64-min.js',
					'/public/js/cryptojs/enc-utf16-min.js',
					'/public/js/cryptojs/format-hex-min.js',
				),
				'hash_functions'=> array (
					'/public/js/cryptojs/hmac-min.js',
					'/public/js/cryptojs/md5-min.js',
					'/public/js/cryptojs/ripemd160-min.js',
					'/public/js/cryptojs/sha1-min.js',
					'/public/js/cryptojs/sha3-min.js',
					'/public/js/cryptojs/sha256-min.js',
					'/public/js/cryptojs/sha224-min.js',
					'/public/js/cryptojs/sha512-min.js',
					'/public/js/cryptojs/sha384-min.js',
				),
				'block_ciphers'	=> array (
					'/public/js/cryptojs/aes-min.js',
					'/public/js/cryptojs/rc4-min.js',
					'/public/js/cryptojs/tripledes-min.js',
				),
				'openssl'		=> array (
					'/public/js/cryptojs/evpkdf-min.js',
				),
			),
		),
		'development'	=> array (
			'css'	=> array (
				'/public/css/bootstrap.min.css',
				'/public/css/bootstrap-theme.min.css',
				'/public/css/custom.css',
			),
			'js'	=> array (
				'/public/js/jquery-2.1.1.min.js',
				'/public/js/bootstrap.min.js',
				'/public/js/bootstrap.file-input.js',
				'/public/js/spin.js',
				'/public/js/front.js',
			),
			'js_ie8'=> array (
				'/public/js/html5shiv.js',
				'/public/js/respond.min.js',
			),
			'cryptojs'	=> array (
				'core'			=> array (
					'/public/js/cryptojs/core.js',
					'/public/js/cryptojs/cipher-core.js',
					'/public/js/cryptojs/lib-typedarrays.js',
					'/public/js/cryptojs/x64-core.js',
				),
				'encoders'		=> array (
					'/public/js/cryptojs/enc-base64.js',
					'/public/js/cryptojs/enc-utf16.js',
					'/public/js/cryptojs/format-hex.js',
				),
				'hash_functions'=> array (
					'/public/js/cryptojs/hmac.js',
					'/public/js/cryptojs/md5.js',
					'/public/js/cryptojs/ripemd160.js',
					'/public/js/cryptojs/sha1.js',
					'/public/js/cryptojs/sha3.js',
					'/public/js/cryptojs/sha256.js',
					'/public/js/cryptojs/sha224.js',
					'/public/js/cryptojs/sha512.js',
					'/public/js/cryptojs/sha384.js',
				),
				'block_ciphers'	=> array (
					'/public/js/cryptojs/aes.js',
					'/public/js/cryptojs/rc4.js',
					'/public/js/cryptojs/tripledes.js',
				),
				'openssl'		=> array (
					'/public/js/cryptojs/evpkdf.js',
				),
			),
		),
	),

);
