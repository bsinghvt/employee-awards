<?php
/*
This reset_password.php page is loaded when the user clicks on the reset password link sent to the user's email.
A simple form is presented where user inputs a new password.
When the user clicks the "Submit" button, ....FINISH UP HERE
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

$verify = addslashes(urldecode($_GET['verify']));
$verifymail = urldecode($_GET['email']);
//echo $verify;
//echo $verifymail;

if (isset($_POST['confirmpwdreset'])) 
{
	$resetpwd="Update User_Account SET password='". password_hash($_POST['newpwd'], PASSWORD_DEFAULT)."' WHERE user_email='".$verifymail."'"; 
	if($mysqli->query($resetpwd))
	{
		$removeverifystring="Update User_Account SET forgot_password='' WHERE user_email='".$verifymail."'";
		$mysqli->query($removeverifystring);
	}
	echo '<b>Your Password has been reset successfully. <a href="login.php">Login</a> with your new password.</b>';
}
else
{
	if($verify!='')
	{
		$sql = "SELECT * FROM User_Account WHERE forgot_password= '" . $verify . "' AND user_email = '" .$verifymail . "';";
		$result = $mysqli->query($sql);
		$numrows = mysqli_num_rows($result);
		//echo "numrows = " . $numrows;
		if($numrows == 1) 
		{
			$row = mysqli_fetch_assoc($result);
			echo "<br><h3>Hello! </h3><br>";
			echo "You can now reset your password:<br><br>";
?>

			<form name="reset" action="reset_password.php?email=<?php echo $_GET['email'];?>&verify=<?php echo $_GET['verify'];?>" method="post">
			<table>
			<tr>
			<td>New password: </td><td><input type="password" name="newpwd" id="newpwd"></td>
			</tr>
			<tr>
			<td>Confirm password: </td><td><input type="password" name="confirmpwd" id="confirmpwd"></td>
			</tr>
			<tr>
			<td></td><td><input type="submit" name="confirmpwdreset" value="Confirm" id="confirmpwdreset"></td>
			</tr>
			</table>
		
<?php
		} 

		else 
		{
			echo "The link is either INVALID or has expired";
		}
	}
	else 
	{
		echo "The link is either invalid or has expired";
	}
}
?>
