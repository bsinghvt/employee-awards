<?php
require_once(__DIR__.'/website-files/initialize.php');
//ob_start(); //from stack overflow
include 'pass.php';
error_reporting(E_ALL);
ini_set('display_errors','On');
//session_start();
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
	if (!($stmt = $mysqli->prepare("SELECT first_name, middle_name, last_name, job_title, password, signature from User_Account WHERE uid=?"))) {
     echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$stmt->bind_param("i", $uid)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}
if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
$stmt->bind_result($AFirstName, $AMiddleName, $ALastName, $job_title, $pass, $signature);

    
    $stmt->fetch();
$stmt->close();
?>
<body>
<div class="form-group">
    <form method="post" action="edituserinfo.php" enctype="multipart/form-data"> 
        <fieldset>
				<legend>Registration</legend>
				<p>User email (will be username): <input type="email" name="user_email" value="<?php echo htmlspecialchars($_SESSION["user_email"]); ?>" required /></p>
		<p>Password: <input type="password" name="password" value="<?php echo htmlspecialchars($pass); ?>" required /></p>
		<p>First name: <input type="text" name="first_name" value="<?php echo htmlspecialchars($AFirstName); ?>" required /></p>
		<p>Middle name (optional): <input type="text" name="middle_name" value="<?php echo htmlspecialchars($AMiddleName); ?>" /></p>
		<p>Last name: <input type="text" name="last_name" required value="<?php echo htmlspecialchars($ALastName); ?>" /></p>
		<p>Job Title: <input type="text" name="job_title" required value="<?php echo htmlspecialchars($job_title); ?>" /></p>
		<p>New Signature:  <input type="file" name="signature" accept="image/*"/> </p>
		<label>Current Signature</label>
<?php echo "<img src=./website-files/sig-images/".$signature. " width=\"175\" height=\"200\" />" ?>
		<br><br>
		<input type="submit" value="Update">
        </fieldset>
	 </form>
</div>
<p>If you would like to delete your account <a href="deleteaconfirm.php"> click here </a>
</body>
<?php get_template("footer.php"); 
 ?>