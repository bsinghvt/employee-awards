<?php
ob_start(); //from stack overflow
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__.'/website-files/initialize.php');
$error=0;
get_template("header.php");
if(isset($_POST['user_email'])) {
	include 'pass.php';
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "harrings-db", $pass, "harrings-db");
    if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$accounts=array();
	if (!$stmt = $mysqli->query("SELECT user_email FROM User_Account")) {
			echo "Query Failed!: (" . $mysqli->errno . ") ". $mysqli->error;
		}
	while($row = mysqli_fetch_array($stmt))
	{
		if (((!in_array($row['user_email'], $accounts)))&&($row['user_email']!=null))
		{
			array_push($accounts,$row['user_email']);
		}	
	}
	if (($_POST["user_email"]==null))
	{
		echo "Error to add an account it must have an email click <a href=\"register.php\">here</a> to return to account creation screen";
	}
	else if (($_POST["password"]==null))
	{
		echo "Error to add an account it must have a password click <a href=\"register.php\">here</a> to return to account creation screen";
	}
	else if (($_POST["signature"]==null))
	{
		echo "Error to add an account it must have a signature click <a href=\"register.php\">here</a> to return to account creation screen";
	}
	else if (($_POST["first_name"]==null))
	{
		echo "Error to add an account it must have a first name click <a href=\"register.php\">here</a> to return to account creation screen";
	}
	else if (($_POST["last_name"]==null))
	{
		echo "Error to add an account it must have a last name click <a href=\"register.php\">here</a> to return to account creation screen";
	}
	else if (($_POST["job_title"]==null))
	{
		echo "Error to add an account it must have a job title click <a href=\"register.php\">here</a> to return to account creation screen";
	}
	else if (in_array($_POST['user_email'], $accounts))
	{
		echo "Could not add account as there is already another user name of " . $_POST["user_email"] . " click <a href=\"register.php\">here</a> to return to account creation screen";
	}
	else
	{
		$user_email=$_POST["user_email"];
		$password=$_POST["password"];
		$signature=$_POST["signature"];
		$first_name=$_POST["first_name"];
		$last_name=$_POST["last_name"];
		$job_title=$_POST["job_title"];
		$creation=date('Y-m-d H:i:s');
		$middle_name=$_POST["middle_name"];
		if (($_POST["middle_name"]==null))
		{
			$middle_name= "none";
		}
		if (!($stmt = $mysqli->prepare("INSERT INTO User_Account(user_email, password, creation , signature, first_name, middle_name, last_name, job_title) VALUES (?,?,?,?,?,?,?,?)"))) {
			 echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			 $error=1;
		}
		if (!$stmt->bind_param("ssssssss", $user_email, $password, $creation, $signature, $first_name, $middle_name, $last_name, $job_title)) {
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
			$message= "registered successfully";
			/*
			session_start();
			$_SESSION["user_email"]=$_POST["user_email"];
			$_SESSION["units"]=$units;
			$_SESSION["teacher"]=$teacher;
			header("Location: switch.php", true);
			*/
		}
		else
		{
			echo "Error there is already an account with that user name click <a href=\"index.php\">here</a> to return to login page";
		}
	}
}
else
{
	$message = "Unable to register user as registration form was not completed";
}	
$links= "click <a href=\"register.php\">here</a> to return to account creation screen or click <a href=\"login.php\">here</a> to login";
echo output_message($message); 
echo output_message($links); 
?>






<?php get_template($template = "footer.php"); ?>