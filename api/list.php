<?php

require('../resources/fetch.php');

echo getPoints($_REQUEST['user'], $_REQUEST['longitude'], $_REQUEST['latitude']);
