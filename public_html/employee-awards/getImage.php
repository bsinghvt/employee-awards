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
include 'pass.php';
$uid=$_SESSION["uid"];
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "harrings-db", $pass, "harrings-db");
    if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	if (!($stmt = $mysqli->prepare("SELECT signature from User_Account WHERE uid=?"))) {
     echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$stmt->bind_param("i", $uid)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}
if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
$stmt->bind_result($sig);

    
    $stmt->fetch();
$stmt->close();
header("Content-type: image/png");
  echo $sig;
?>