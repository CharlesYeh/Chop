<?php

require('database.php');

/**
 * find availabilities around given coord
 */
function getPoints($user, $long, $lat) {
	$dLong = 1;
	$dLat = 1;

	return getPointsInBox($user, $long - $dLong, $long + $dLong,
		$lat - $dLat, $lat + $dLat);
}

/**
 * find availabilities within bounding box
 */
function getPointsInBox($user, $minLong, $maxLong, $minLat, $maxLat) {
	// sanitization
	$user = mysql_real_escape_string(substr($user, 0, 32));

	// 1 minute cutoff
	$cutoff = time() - 60;
	$result = mysql_query("SELECT * FROM people WHERE
		latitude > {$minLat} AND latitude < {$maxLat} AND
		longitude > {$minLong} AND longitude < {$maxLong} AND createTime > {$cutoff};");
	
	/*if (mysql_num_rows($result) > 200) {
		$result = mysql_query("SELECT * ");
	}*/

	$output = array();
	
	$showSelf = (mysql_num_rows($result) == 1);
	
	// get row in db
	while ($row = mysql_fetch_assoc($result)) {
		if ($row['user'] == $user) {
			if ($showSelf) {
				$output[] = (object) array(
					'user' => $row['user'],
					'blurb' => '[no people are online :( this is you]',
					'longitude' => doubleval($row['longitude']),
					'latitude' => doubleval($row['latitude']),
					'createTime' => intval($row['createTime']));
			}
		}
		else {
			$output[] = (object) array(
				'user' => $row['user'],
				'blurb' => $row['blurb'],
				'longitude' => doubleval($row['longitude']),
				'latitude' => doubleval($row['latitude']),
				'createTime' => intval($row['createTime']));
		}
	}
	
	return json_encode($output);
}
