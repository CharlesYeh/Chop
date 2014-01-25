<?php

require('../resources/ping.php');

pingOn($_REQUEST['user'], $_REQUEST['blurb'], $_REQUEST['longitude'], $_REQUEST['latitude']);
