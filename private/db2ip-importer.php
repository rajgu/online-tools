<?php

/*
*
* @file: db2ip-importer.php
* Konwerter pliku csv pobranego z https://db-ip.com/db/#downloads
*
*/

if ($argc != 6) {
	die ("Nie prawidlowe argumenty wejsciowe:\n\t UZYCIE:\n\t\t{$argv['0']} file_name db_host db_user db_pass db_base\n");
}

if (! file_exists ($argv[1]) OR ! $file = fopen ($argv[1], "r")) {
	die ("Cant open: {$argv[1]}\n");
}

mysql_connect ($argv[2], $argv[3], $argv[4]);
mysql_select_db ($argv[5]);

if (mysql_error ()) {
	die (mysql_error ()."\n");
}

$import = array ();

while (($line = fgetcsv ($file)) !== FALSE) {

	$line[0] = ip2long ($line[0]);
	$line[1] = ip2long ($line[1]);

	$import[] = $line;

	if (count ($import) == 1000) {
		importer ($import);
		$import = array ();
	}

}

importer ($import);

function importer ($data) {
	static $added = 0;

	if (empty ($data))
		return;

	$num = count ($data);

	$values = array ();
	foreach ($data AS $record) {
		$values[] = "(" . implode (",", array_map (function ($r) {return "'" . mysql_real_escape_string ($r) . "'"; }, $record) ) . ")";
	}

	$values = implode (',', $values);
	$query = "INSERT INTO `ips` (`ip_from`, `ip_to`, `country`, `region`, `city`) VALUES $values";

	mysql_query ($query);
	if (mysql_error ())
		die (mysql_error () . "\n");

	$added += $num;

	print ("ADDED: \t$num\t ALL:\t $added\n");
}