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


header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=certificate_style3.pdf");
@readfile('certificate_style3.pdf');

// echo "<iframe src=\"certificate_style3.pdf\" width=\"75%\" style=\"height:75%\"></iframe>";
?>
<p>Use the back button to make changes to your certificate. Or else, send your certificate by clicking below.</p>
<input type="button" name="submit" id="submit" value="Send Certificate" onclick="send_certificate.php" />