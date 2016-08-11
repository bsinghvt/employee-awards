<?php
require_once(__DIR__.'/website-files/initialize.php');
include 'pass.php';
error_reporting(E_ALL);
ini_set('display_errors','On');
//session_start();
if (!isset($_SESSION["user_email"]))
{
    header("Location: login.php", true);
}
$uid=$_SESSION["uid"];
$file_name = $_SESSION['file_name'];
//echo "session middle name set = ". $_SESSION["middlenameset"] . "\r";
header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=".$file_name.".pdf");
@readfile($file_name.".pdf");
unlink($file_name.".pdf");
unlink($file_name.".log");
unlink($file_name.".aux");
unlink("data.csv");

?>
