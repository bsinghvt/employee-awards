<?php
require_once(__DIR__.'/website-files/initialize.php');
ob_start(); //from stack overflow
include 'pass.php';
error_reporting(E_ALL);
ini_set('display_errors','On');
session_start();
if (!isset($_SESSION["user_email"]))
{
    header("Location: login.php", true);
}
get_template("header.php");
get_template("nav2.php");
?>
<p>Are you sure you wish to delete your account: Note all awards you have given will be deleted from database as well </p>
<p><a href="deleteuser.php">Click here </a> to delete or <a href="edituserinfo.php">Return to account editing</a>
<?php get_template("footer.php"); 
 ?>