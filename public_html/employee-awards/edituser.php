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
include 'pass.php';
$uid=$_SESSION["uid"];
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "harrings-db", $pass, "harrings-db");
    if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	if (!($stmt = $mysqli->prepare("SELECT first_name, middle_name, last_name, job_title from User_Account WHERE uid=?"))) {
     echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$stmt->bind_param("i", $uid)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}
if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
$stmt->bind_result($AFirstName, $AMiddleName, $ALastName, $job_title);

    
    $stmt->fetch();
$stmt->close();
?>
<body>
<img src="getImage.php" width="175" height="200" />
</body>
<?php get_template("footer.php"); 
 ?>