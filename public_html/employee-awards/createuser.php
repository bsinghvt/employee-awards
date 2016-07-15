<?php
ob_start(); //from stack overflow
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__.'/website-files/initialize.php');
$error=0;
get_template("header.php");
if(isset($_POST['user_email'])) 
{
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
	else if (($_FILES["signature"]==null))
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
		if($_FILES["signature"]['size'] > 204800)
		{
			echo'<p style="color:red;"> <b>Error: Image of your signature cannot be greater than 200KB.</b></p>';
			return;
		}
		$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
		$detectedType = exif_imagetype($_FILES["signature"]['tmp_name']);
		if(!in_array($detectedType, $allowedTypes))
		{
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


		// If Submit button is clicked in register.php, then make unique file name to signature file,
		// and store signature file in /website-files/sig-images/.
		if(isset($_POST['btn-upload']))
		{    
		     
			$file = rand(1000,100000)."-".$_FILES['signature']['name'];
			$file_loc = $_FILES['signature']['tmp_name'];
			$folder=__DIR__."/website-files/sig-images/";
			 
			// make file name in lower case
			$new_file_name = strtolower($file);

			// get rid of spaces in file name 
			$final_file=str_replace(' ','-',$new_file_name);
		 

			$user_email=$_POST["user_email"];
			$password=$_POST["password"];
			$first_name=$_POST["first_name"];
			$last_name=$_POST["last_name"];
			$job_title=$_POST["job_title"];
			$creation=date('Y-m-d H:i:s');
			$sig=$final_file; //unique file name that was generated earlier
			$middle_name=$_POST["middle_name"];
			if (($_POST["middle_name"]==null))
			{
				$middle_name= "none";
			}


			if(move_uploaded_file($file_loc,$folder.$final_file))
			{
			    //if (!$stmt2 = $mysqli->query("INSERT INTO Signature(sig_file,sig_type,sig_size) VALUES('$final_file','$file_type','$new_size')")) {
			    //  echo "Query Failed!: (" . $mysqli->errno . ") ". $mysqli->error;
			    //}
			    if (!($stmt = $mysqli->prepare("INSERT INTO User_Account(user_email, password, creation, signature , first_name, middle_name, last_name, job_title) VALUES (?,?,?,?,?,?,?,?)"))) 
			    {
				 echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
				 $error=1;
				}
				if (!$stmt->bind_param("ssssssss", $user_email, $password, $creation, $sig, $first_name, $middle_name, $last_name, $job_title)) 
				{
					echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
					$error=1;
				}
				if (!$stmt->execute()) 
				{
					echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
					$error=1;
				}
				$stmt->close();

				?>
				<script>
					alert('successfully uploaded');
				</script>
				<?php
			}
			else
			{
				?>
				<script>
					alert('error while uploading file');
				</script>
				<?php
				$error = 1;
			}
		}








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
			$message= "Error there is already an account with that user name click <a href=\"index.php\">here</a> to return to login page";
		}
	} //
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