<?php

require('../resources/chat.php');

chat($_REQUEST['poster'], $_REQUEST['receiver'], $_REQUEST['message']);
