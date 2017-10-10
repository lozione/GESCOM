<?php

// INITIATE SESSION
session_start();
ini_set('default_charset', 'utf-8');

// mysql_connect
$host="localhost";
$port="3306";
$user="root";
$passwd="";
$defaultdb ="cedolini";

require 'libs/rb.php'; 
R::setup( "mysql:host=$host;dbname=$defaultdb",$user, $passwd ); //for both mysql or mariaDB

spl_autoload_register(function ($class) {
	if (file_exists("libs/{$class}.php")) { include "libs/{$class}.php"; }	
});

// DATABASE SETTINGS
define('DB_HOST', 'localhost');
define('DB_NAME', 'cedolini');
define('DB_USER', 'root');
define('DB_PASS', '');






