<?php
session_start();

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'charm');

mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD)or die(mysql_error()); 
mysql_select_db(DB_DATABASE)or die(mysql_error());

$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
$database = mysql_select_db(DB_DATABASE) or die(mysql_error());
?>