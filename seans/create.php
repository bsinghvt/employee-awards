<?php
ob_start(); //from stack overflow
include 'pass.php';
error_reporting(E_ALL);
ini_set('display_errors','On');
$error=0;
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "harrings-db", $pass, "harrings-db");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Create Account Password</title>
  <link rel="stylesheet" href="main.css" type="text/css" />
  <div>
  <h1>Course Tracker</h1>
  </div>
</head>
<body>
<section>
<?php
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$accounts=array();
if (!$stmt = $mysqli->query("SELECT username FROM USERDB")) {
		echo "Query Failed!: (" . $mysqli->errno . ") ". $mysqli->error;
	}
while($row = mysqli_fetch_array($stmt))
{
	if (((!in_array($row['username'], $accounts)))&&($row['username']!=null))
	{
		array_push($accounts,$row['username']);
	}	
}
if (($_POST["username"]==null))
{
	echo "Error to add an account it must have a name click <a href=\"index.php\">here</a> to return to login screen";
}
else if (($_POST["password"]==null))
{
	echo "Error to add an account it must have a password click <a href=\"index.php\">here</a> to return to login screen";
}
else if (($_POST["units"]==null))
{
	echo "Error to add an account it must have a number of units click <a href=\"index.php\">here</a> to return to login screen";
}
else if (in_array($_POST['username'], $accounts))
{
	echo "Could not add account as there is already another user with that Username click <a href=\"index.php\">here</a> to return to login screen";
}
else
{
	$name=$_POST["username"];
	$category=$_POST["password"];
	$units=$_POST["units"];
	$secret=$_POST["secretnumber"];
	$teacher=$_POST["teacher"];

	if (!($stmt = $mysqli->prepare("INSERT INTO USERDB(username, password, units, secretnumber, teacher) VALUES (?,?,?,?,?)"))) {
		 echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		 $error=1;
	}
	if (!$stmt->bind_param("ssiii", $name, $category, $units, $secret, $teacher)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		$error=1;
	}
	if (!$stmt->execute()) {
		//echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		$error=1;
	}
	$stmt->close();
	if ($error==0)
	{
		session_start();
		$_SESSION["username"]=$_POST["username"];
		$_SESSION["units"]=$units;
		$_SESSION["teacher"]=$teacher;
		header("Location: switch.php", true);
	}
	else
	{
		echo "Error there is already an account with that user name click <a href=\"index.php\">here</a> to return to login page";
	}
}
?>
</section>
</body>
</html>