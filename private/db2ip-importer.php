<?php

/*
*
* @file: db2ip-importer.php
* Konwerter pliku csv pobranego z https://db-ip.com/db/#downloads
* Na wyjście trafiają inserty do bazy danych.
*
*/

define ('BATCH_SIZE', 1000);

if ($argc != 2) {
	die ("Nieprawidlowe argumenty wejsciowe:\n\t UZYCIE:\n\t\t{$argv['0']} file_name\n");
}

if (! file_exists ($argv[1]) OR ! $file = fopen ($argv[1], "r")) {
	die ("Cant open: {$argv[1]}\n");
}

$import4 = array ();
$import6 = array ();

while (($line = fgetcsv ($file)) !== FALSE) {

	if (filter_var ($line[0], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {

		$line[0] = ip2long ($line[0]);
		$line[1] = ip2long ($line[1]);

		$import4[] = $line;
	}

	if (filter_var ($line[0], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {

		$line[0] = ipv6ToDecimal ($line[0]);
		$line[1] = ipv6ToDecimal ($line[1]);

		$import6[] = $line;
	}

	if (count ($import4) == BATCH_SIZE) {
		importer ($import4, 'ipv4');
		$import4 = array ();
	}

	if (count ($import6) == BATCH_SIZE) {
		importer ($import6, 'ipv6');
		$import6 = array ();
	}

}

importer ($import4, 'ipv4');
importer ($import6, 'ipv6');

function importer ($data, $table) {
	static $added = 0;

	if (empty ($data))
		return;

	$num = count ($data);

	$values = array ();
	foreach ($data AS $record) {
		$values[] = "(" . implode (",", array_map (function ($r) {return "'" . escape_like_mysql ($r) . "'"; }, $record) ) . ")";
	}

	$values = implode (',', $values);
	print ("INSERT INTO `$table` (`ip_from`, `ip_to`, `country`, `region`, `city`) VALUES $values;\n");
}

function ipv6ToDecimal ($input) {
    $parts = unpack('N*', inet_pton ($input));

    // fix IPv4
    if (strpos ($input, '.') !== false)
        $parts = array (1=>0, 2=>0, 3=>0, 4=>$parts[1]);

    foreach ($parts as &$part) {
        // convert any unsigned ints to signed from unpack.
        // this should be OK as it will be a PHP float not an int
        if ($part < 0)
            $part += 4294967296;
    }

    $decimal = $parts[4];
    $decimal = bcadd ($decimal, bcmul ($parts[3], '4294967296'));
    $decimal = bcadd ($decimal, bcmul ($parts[2], '18446744073709551616'));
    $decimal = bcadd ($decimal, bcmul ($parts[1], '79228162514264337593543950336'));

    return $decimal;
}


function escape_like_mysql ($input) {

    if (is_array ($input))
        return array_map (__METHOD__, $inp); 

    if ( ! empty ($input) && is_string ($input))
        return str_replace (array ('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array ('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $input);

	return $input;
}