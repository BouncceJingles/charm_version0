<?php
session_start();
session_destroy();

$_SESSION['login'] = '0';
include"../config/_dbconnect.php";

$nric = strtoupper($_GET['nric']);
$code = $_GET['code'];
$newpw = md5($_GET['newpw']);

mysql_query("UPDATE `logins` SET password='$newpw',locked='0' WHERE password='$code' AND nric='$nric'") or die(mysql_error());

echo json_encode( array('success' => 1) );
?>