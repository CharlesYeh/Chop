<?php

require('../resources/chat.php');

echo getChats($_REQUEST['poster'], $_REQUEST['receiver'], $_REQUEST['lastId']);
