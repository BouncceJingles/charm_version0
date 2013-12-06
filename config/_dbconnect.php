<?php
session_start();

define('DB_SERVER', 'mysql6.000webhost.com');
define('DB_USERNAME', 'a9810835_charm');
define('DB_PASSWORD', '`12345q');
define('DB_DATABASE', 'a9810835_charm');

mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD)or die(mysql_error()); 
mysql_select_db(DB_DATABASE)or die(mysql_error());

$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
$database = mysql_select_db(DB_DATABASE) or die(mysql_error());
?>