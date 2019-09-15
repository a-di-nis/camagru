<?php

define('APPROOT', dirname(__FILE__));

// Load Helpers
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';
require_once 'helpers/send_email.php';

spl_autoload_register(function($className)
{
	require_once 'libraries/' . $className . '.php';
});