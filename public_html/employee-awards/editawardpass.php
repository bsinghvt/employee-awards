<?php
require_once(__DIR__.'/website-files/initialize.php');
//session_start();
//ob_start(); //from stack overflow
error_reporting(E_ALL);
ini_set('display_errors','On');
if (!isset($_SESSION["user_email"]))
{
    header("Location: login.php", true);
}
if(isset($_POST['adid']))
{
$adid=$_POST["adid"];
$_SESSION['adid']=$adid;
}
header("Location: editaward.php", true);
 ?>