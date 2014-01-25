<?php

require('database.php');

$user		= $_REQUEST['user'];
$value 	= $_REQUEST['value'];
$blurb 	= $_REQUEST['blurb'];
$longitude	= $_REQUEST['longitude'];
$latitude		= $_REQUEST['latitude'];

// sanitization
$user 	= mysql_real_escape_string(substr($blurb, 0, 32));
$value	= intval($value);
$blurb	= substr($blurb, 0, min(strlen($blurb), 140));
$longitude	= doubleval($longitude);
$latitude		= doubleval($latitude);

if ($value == 0) {
	
}
else {
	// i'm available!!
	$result = mysql_query("SELECT * ");
	if (mysql_num_rows($result) > 200) {
		$result = mysql_query("SELECT * ");
	}
	
	// get row in db
	while ($row = mysql_fetch_assoc($result)) {
		$row['user'];
		$row['blurb'];
		$row['longitude'];
		$row['longitude'];
		$row['latitude'];
	}
	
}
