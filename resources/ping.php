<?php

require('database.php');

/**
 * turn on availability for $user
 */
function pingOn($user, $blurb, $longitude, $latitude) {
	// sanitization
	$user = mysql_real_escape_string(substr($user, 0, 32));
	$blurb = mysql_real_escape_string(substr($blurb, 0, min(strlen($blurb), 140)));
	$longitude = doubleval($longitude);
	$latitude = doubleval($latitude);
	$createTime = time();
	
	// i'm available!!
	$result = mysql_query("UPDATE people SET createTime = {$createTime} WHERE user = '{$user}'");
	if (mysql_affected_rows($result) == 0) {
		$result = mysql_query("INSERT INTO people VALUES ('{$user}', '{$blurb}',
			'{$longitude}', '{$latitude}', '{$createTime}')");
	}
}

function pingOff($user) {
	$user = mysql_real_escape_string(substr($user, 0, 32));

	$result = mysql_query("DELETE FROM people WHERE user = '{$user}'");
}
