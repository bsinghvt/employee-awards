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
//echo "session middle name set = ". $_SESSION["middlenameset"] . "\r";
if($_SESSION["middlenameset"] == "false")
{
	header("Content-type: application/pdf");
	header("Content-Disposition: inline; filename=certificate_style3_no_middle_name.pdf");
	@readfile('certificate_style3_no_middle_name.pdf');
}
else
{
	header("Content-type: application/pdf");
	header("Content-Disposition: inline; filename=certificate_style3.pdf");
	@readfile('certificate_style3.pdf');
}
?>
