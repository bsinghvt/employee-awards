<?php
require_once(__DIR__.'/website-files/initialize.php');
//ob_start(); //from stack overflow
include 'pass.php';
error_reporting(E_ALL);
//ini_set('display_errors','On');
//session_start();
$units=0;
$username=$_POST["username"];
$password=$_POST["password"];
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "harrings-db", $pass, "harrings-db");

if ($mysqli->connect_errno) 
{
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

// if (!($stmt = $mysqli->prepare("SELECT uid from User_Account WHERE user_email=? and password=?"))) {
//      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
// }
// if (!$stmt->bind_param("ss", $username, $password)) {
//     echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
// }
// if (!$stmt->execute()) {
//     echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
// }
// $stmt->bind_result($units);

    
//     $stmt->fetch();
// $stmt->close();

$sql = "SELECT * FROM User_Account WHERE user_email= '" . $username . "';";

if(!($result = $mysqli->query($sql)))
{
	echo "Query failed: (" . $sql->errno . ") " . $sql->error;
}


$numrows = mysqli_num_rows($result);
//echo "numrows = " . $numrows . "\r";

if($numrows == 1) 
{
	$row = mysqli_fetch_assoc($result);
	$hash = $row['password']; //Get hashed password from database.
	$units = $row['uid'];
	//echo "hash = " . $hash . "\r";
	//echo "units = " . $units . "\r";
	//echo "password = " . $password . "\r";

}

//$pass_correct = password_verify($password, $hash);
//echo "pass_correct = " . $pass_correct . "\r";

if ($units>0 && password_verify($password, $hash) )
{
	echo "Login Successful";
	$_SESSION["uid"]=$units;
	$_SESSION["user_email"]=$username;
	
}
?>