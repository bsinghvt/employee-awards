<?php
/*
This forgot_password.php page is loaded when the user is at the login page (login.php) and clicks on the "Forgot your password?" button.
A simple form is presented where user inputs the email (same as username) used to register at this site.
When the user clicks the "Submit" button, an email is sent to the given email address with an encoded, one time password 
reset link to the registered mail id. Clicking on the reset link loads the reset_password.php page.
*/

error_reporting(E_ALL);
ini_set('display_errors','On');

require_once(__DIR__.'/website-files/initialize.php');

require_once '../phpmailer/vendor/autoload.php';
include("../../secret.php");
include 'pass.php';

//Connect to database.
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "harrings-db", $pass, "harrings-db");
if ($mysqli->connect_errno) 
{
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;	
}

//Get inputted email address from the form and check that this is a registered username.
if(isset($_POST['submit'])) 
{
	$selectuser="Select * from User_Account where user_email='".addslashes($_POST['email'])."'";
	$result = $mysqli->query($selectuser);
	$numrows = mysqli_num_rows($result);
	//echo "numrows = " . $numrows . "\r\r";

	if($numrows == 1) 
	{
		//echo "made it here\r\r";

		$row = mysqli_fetch_assoc($result);
		$validusername=$row['user_email'];

		//echo "valid user name = " . "\'" . $validusername . "\'" . "\r\r";

		$randomstring = "";
		for($i = 0; $i < 16; $i++) 
		{
			$randomstring .= chr(mt_rand(1,126));
		}

		$verifyurl = "reset_password.php";
		$verifystring = urlencode($randomstring);
		$verifyemail = urlencode($_POST['email']);
		$verifyurlstring = $verifyurl . '?email=' . $verifyemail . '&verify=' . $verifystring;
		$html = '<body>
		 		Hi,<br>
				A request has been made to reset the password for your account.<br>
				Please click on the following link to go to the password reset page:<br>
				<a href="' . $verifyurlstring . '">Click Here.</a>
				</body>';
		//Input forgotten_password random string into the database for this user.
		$updateuser="Update User_Account SET forgot_password='".addslashes($randomstring)."' WHERE user_email='".addslashes($_POST['email'])."'";
		$mysqli->query($updateuser);
		//echo "updateuser = " . $updateuser. "\r\r";

		$mail_body=<<<_MAIL_
Hi,
A request has been made to reset the password for your account.
Please click on the following link to go to the password reset page:
web.engr.oregonstate.edu/~tanabana/employee-awards/$verifyurl?email=$verifyemail&verify=$verifystring
_MAIL_;

		$m = new PHPMailer;

		$m->isSMTP();
		$m->SMTPAuth = true;
		//$m->SMTPDebug = 2;
		$m->IsHTML(true); 

		$m->Host = 'smtp.gmail.com';
		$m->Username = 'webrecogapp@gmail.com';
		$m->Password =  $myPassword;
		$m->SMTPSecure = 'ssl';
		$m->Port = 465;

		$m->From = 'webrecogapp@gmail.com';
		$m->FromName = "Employee Awards Website Application";
		//$m->MsgHTML($html);
		$m->Subject = 'User Verification to Reset Password';
		//$m->Body = $html;
		// $m->Body = '<body>
		// 			Hi,<br>
		// 			A request has been made to reset the password for your account.<br>
		// 			Please click on the following link to go to the password reset page:<br>
		// 			<a href="' . $verifyurlstring . '">Click Here.</a>
		// 			</body>';

		//  $m->Body = '<body>
		//  			Hi,<br>
		// 			A request has been made to reset the password for your account.<br>
		// 			Please click on the following link to go to the password reset page:<br>
		// 			<a href="/~tanabana/employee-awards/reset_password.php">Click Here.</a>
		// 			</body>';
		// //$m->Body = '<body><a href="' . $verifyurl . '?email=' . $verifyemail . '&verify=' . $verifystring . '">Click Here.</a>
		//			</body>';

		$m->Body = $mail_body;

		$m->AddAddress($_POST['email']);  // Send reset link to given email address
		if(!$m->Send())
		{
			echo "Message was not sent<br/ >";
			echo "Mailer Error: " . $m->ErrorInfo;
		}
		else
		{
			echo "<p>A link has been
			emailed to the address you entered.<br>
			Please follow the link in the email to reset the password for 
			your account.</p><br>";
			echo '<br><p><a href="login.php"> Back to Login Page</a></p>';
		}
	}
	else //In the case where the numrows returned is not equal to 1 (i.e., it is 0), which means user with that email is not registered.
	{
		echo "We could not find any registered user with the email (username) as ".addslashes($_POST['email'])."<br>
		Please Enter the correct email (username) & try again.";
	}
}
else
{
?>
	<div id="content">
	<form action="forgot_password.php" method="post">
	<table>
	<tr>
	<td>Enter the email (username) you registered with:</td>
	<td><input type="text" name="email"></td>
	</tr>
	<tr>
	<tr>
	<td></td>
	<td><input type="submit" name="submit" value="Submit"></td>
	</tr>
	</table>
	</form>
	</div>
<?php
}
?>