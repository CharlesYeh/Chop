<?php

require('database.php');

function getChatters($poster) {
	$poster = mysql_real_escape_string(substr($poster, 0, 32));
	$dayold = time() - 24 * 60 * 60;
	
	$chatters = array();
	$result = mysql_query("SELECT * FROM messages WHERE (poster = '{$poster}' OR receiver = '{$poster}') AND createTime > {$dayold}");
	while ($row = mysql_fetch_assoc($result)) {
		$chatters[$row['poster']] = true;
		$chatters[$row['receiver']] = true;
	}
	
	unset($chatters[$poster]);
	
	$ch = array_keys($chatters);
	$cq = "'" . implode("', '", $ch) . "'";
	
	$result = mysql_query("SELECT * FROM people WHERE user IN ({$cq})");
	$ret = array();
	while ($row = mysql_fetch_assoc($result)) {
		unset($chatters[$row['user']]);
		$ret[] = $row;
	}
	
	foreach (array_keys($chatters) as $ch) {
		$ret[] = (object) array(
			user => $ch,
			longitude => 0,
			latitude => 0,
			blurb => "(hiding)"
		);
	}
	
	return json_encode($ret);
}
function chat($poster, $receiver, $message) {
	$poster = mysql_real_escape_string(substr($poster, 0, 32));
	$receiver = mysql_real_escape_string(substr($receiver, 0, 32));
	$message = mysql_real_escape_string(substr($message, 0, 250));
	$createTime = time();
	
	mysql_query("INSERT INTO messages (poster, receiver, message, createTime) VALUES ('{$poster}', '{$receiver}', '{$message}', {$createTime})");
}
function getChats($poster, $receiver, $lastId) {
	// sanitization
	$poster = mysql_real_escape_string(substr($poster, 0, 32));
	$receiver = mysql_real_escape_string(substr($receiver, 0, 32));
	$lastId = intval($lastId);
	
	// i'm available!!
	$result = mysql_query("SELECT * FROM messages WHERE id > {$lastId} AND ((poster = '{$poster}' AND receiver = '{$receiver}') OR (poster = '{$receiver}' AND receiver = '{$poster}')) ORDER BY id ASC");
	$msgs = array();
	while ($row = mysql_fetch_assoc($result)) {
		$msgs[] = $row;
	}
	
	return json_encode($msgs);
}
