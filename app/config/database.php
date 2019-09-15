<?php 

$DB_HOST = "localhost";
$DB_USER = 'root';
$DB_PASS = 'root';
$DB_NAME = 'camagru';
$DB_PORT = '8889';
$DB_DSN_LIGHT = "mysql:host=" . $DB_HOST . ";port=" . $DB_PORT;
$DB_DSN = $DB_DSN_LIGHT . ";dbname=" . $DB_NAME;