<?php
session_start();
session_destroy();

$_SESSION['login'] = '0';
header("Location: /index.php");
?>