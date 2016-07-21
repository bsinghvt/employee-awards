<?php
ob_start(); //from stack overflow
include 'pass.php';
error_reporting(E_ALL);
ini_set('display_errors','On');
require_once(__DIR__.'/website-files/initialize.php');
session_start();
if (!isset($_SESSION["user_email"]))
{
    header("Location: login.php", true);
}
$uid=$_SESSION["uid"];
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
	$stmt->close();
	if (($_POST["user_email"]==null))
	{
		echo "Error to update an account it must have an email click <a href=\"register.php\">here</a> to return to account creation screen";
	}
	else if (($_POST["password"]==null))
	{
		echo "Error to update an account it must have a password click <a href=\"register.php\">here</a> to return to account creation screen";
	}
	else if (($_FILES["signature"]==null))
	{
		echo "Error to update an account it must have a signature click <a href=\"register.php\">here</a> to return to account creation screen";
	}
	else if (($_POST["first_name"]==null))
	{
		echo "Error to update an account it must have a first name click <a href=\"register.php\">here</a> to return to account creation screen";
	}
	else if (($_POST["last_name"]==null))
	{
		echo "Error to update an account it must have a last name click <a href=\"register.php\">here</a> to return to account creation screen";
	}
	else if (($_POST["job_title"]==null))
	{
		echo "Error to update an account it must have a job title click <a href=\"register.php\">here</a> to return to account creation screen";
	}
	else if (in_array($_POST['user_email'], $accounts)&&($_POST['user_email']!=$_SESSION['user_email']))
	{
		$message= "Could not update account as there is already another user name of " . $_POST["user_email"] . " click <a href=\"register.php\">here</a> to return to account creation screen";
	}
	else
	{
		$user_email=$_POST["user_email"];
		$_SESSION["user_email"]=$user_email;
		$password=password_hash($_POST["password"], PASSWORD_DEFAULT);
		$first_name=$_POST["first_name"];
		$last_name=$_POST["last_name"];
		$job_title=$_POST["job_title"];
		$middle_name=$_POST["middle_name"];
		if($_FILES["signature"]['size'] ==0) //no new signature
		{
			if (!($stmt = $mysqli->prepare("Update User_Account SET user_email=?, password=?, first_name=?, middle_name=?, last_name=?, job_title=? WHERE uid='$uid'"))) {
				 echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
				 $error=1;
			}
			if (!$stmt->bind_param("ssssss", $user_email, $password, $first_name, $middle_name, $last_name, $job_title)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				$error=1;
			}
			if (!$stmt->execute()) {
				//echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				$error=1;
			}
			$stmt->close();
		}
		else //new signature
		{
			if($_FILES["signature"]['size'] > 204800){
						echo'<p style="color:red;"> <b>Error: Image of your signature cannot be greater than 200KB.</b></p>';
						return;
					}
					$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
					$detectedType = exif_imagetype($_FILES["signature"]['tmp_name']);
					if(!in_array($detectedType, $allowedTypes)){
						echo'<p style="color:red;"> <b>Error: Only JPG, JPEG, PNG & GIF files are allowed for signature.</b></p>';
						return;
					}
					$image_check = getimagesize($_FILES["signature"]['tmp_name']);
					if($image_check==false)
					{
						echo'<p style="color:red;"> <b>Error: Please upload a valid image of your signature.</b></p>';
						return;
					}
					$signature = file_get_contents($_FILES["signature"]['tmp_name']);


	//fclose($fp);
			
			if (!($stmt = $mysqli->prepare("Update User_Account SET user_email=?, password=?, signature=?, first_name=?, middle_name=?, last_name=?, job_title=? WHERE uid='$uid'"))) {
				 echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
				 $error=1;
			}
			if (!$stmt->bind_param("ssbssss", $user_email, $password, $signature, $first_name, $middle_name, $last_name, $job_title)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				$error=1;
			}
			if (!$stmt->execute()) {
				//echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				$error=1;
			}
			$stmt->close();
			
		}
		if ($error==0)
			{
				$message= "updated successfully";
			}
		else
		{
			$message= "Error there is already an account with that user name click <a href=\"edituser.php\">here</a> to return to user info page";
		}
	}
}
else
{
	$message = "Unable to register user as registration form was not completed";
}	
get_template("nav2.php"); 
echo output_message($message);
?>

<?php get_template("footer.php"); 
 ?>

