<?php
session_start();
ob_start(); //from stack overflow
error_reporting(E_ALL);
ini_set('display_errors','On');
session_unset();
session_destroy();
$_SESSION=array();
header("Location: login.php", true);
 ?>