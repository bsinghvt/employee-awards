<?php
require_once(__DIR__.'/website-files/initialize.php');
include 'pass.php';
//session_start();
//ob_start(); //from stack overflow
error_reporting(E_ALL);
ini_set('display_errors','On');
$uid=$_SESSION["uid"];
session_unset();
session_destroy();
$_SESSION=array();
$error=0;
get_template("header.php");
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "harrings-db", $pass, "harrings-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	$error=1;
}
if (!($stmt = $mysqli->prepare("DELETE FROM User_Account WHERE uid=?"))) {
     echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	 $error=1;
}
if (!$stmt->bind_param("s", $uid)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	$error=1;
}
if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	$error=1;
}
$stmt->close();
if($error==1)
{
	$message="Failed to delete account";
}
else
{
	$message= "Successfully deleted account";
}
$links= "click <a href=\"register.php\">here</a> to return to account creation screen or click <a href=\"login.php\">here</a> to login";
echo output_message($message); 
echo output_message($links);
get_template($template = "footer.php");
 ?>