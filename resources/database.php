<?php

/*
 * Logs into the MySQL database
 */

$dbname = 'dbpingg';
// LOCALHOST TESTING
switch ($_SERVER['SERVER_NAME']) {
	case 'localhost':
		$ip = 'localhost';
		$sn = 'root';
		$pw = '';
		
		$db	= mysql_connect($ip, $sn, $pw);
		mysql_select_db('mydb');
		break;
		
	case 'www.eactiv.com':
	case 'eactiv.com':
		$ip	= '10.0.13.112';
		$sn	= $dbname;
		$pw	= 'Yeh!12345';
		
		$db	= mysql_connect($ip, $sn, $pw);
		mysql_select_db($dbname) or var_dump(mysql_error()) or die('Failed to select database ' . $dbname);
		break;
}


if (!$db){
	die("<p>Error connecting to database!</p>");
}

function db_formInsertQueryVars($vars) {
	$varKeys = array_keys($vars);
	$varVals = array_values($vars);
	
	$queryKeys = join(', ', $varKeys);
	$queryVals = join(', ', $varVals);
	
	return "( {$queryKeys} ) VALUES ( {$queryVals} )";
}

function db_formUpdateQueryVars($vars) {
	$parts = array();
	foreach ($vars as $k => $v) {
		$parts[] = "{$k} = {$v}";
	}
	return join(', ', $parts);
}

function db_formSelectAs($vars) {
	$parts = array();
	foreach ($vars as $k => $v) {
		$parts[] = "{$k} AS {$v}";
	}
	return join(', ', $parts);
}

function db_singleQuote($str) {
	return "'{$str}'";
}

function db_hashPW($pw) {
	return md5($pw[strlen($pw) - 1] . md5($pw) . $pw[0]);
}
