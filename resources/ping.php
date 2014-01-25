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
	$result = mysql_query("INSERT INTO people VALUES ('{$user}', '{$blurb}',
		'{$latitude}', '{$longitude}', '{$createTime}')");
	/*if (mysql_num_rows($result) > 200) {
		$result = mysql_query("SELECT * ");
	}
	
	// get row in db
	while ($row = mysql_fetch_assoc($result)) {
		$row['user'];
		$row['blurb'];
		$row['longitude'];
		$row['longitude'];
		$row['latitude'];
	}*/
}

function pingOff($user) {
	$user = mysql_real_escape_string(substr($user, 0, 32));

	$result = mysql_query("DELETE FROM people WHERE user = '{$user}'");
}
