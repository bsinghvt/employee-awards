<?php
include "header.php";
session_start();
ob_start(); //from stack overflow
error_reporting(E_ALL);
ini_set('display_errors','On');
if (isset($_SESSION["username"]))
{
	echo "You are already logged in as $_SESSION[username] <br>";
	echo "if you would like to view your reports click <a href=\"switch.php\">here</a>";
	echo "<br> Click <a href=\"logout.php\">here</a> to logout";
}
else
{
?>
<section id="main" padding-top="0" padding-bottom="0">
<form action="create.php" method="post">
		<p>User email (will be username): <input type="email" name="user_email" required /></p>
		<p>Password: <input type="password" name="password" required /></p>
		<p>First name: <input type="text" name="first_name" required /></p>
		<p>Middle name (optional): <input type="text" name="middle_name" required /></p>
		<p>Last name: <input type="text" name="last_name" required /></p>
		<p>Job Title: <input type="text" name="first_name" required /></p>
		<p>Signature:  <input type="file" name="signature" accept="image/*">
		<br><br>
		<input type="submit" value="Submit">
</form>

</section>	
</body>
</html>

<?php
}
?>
<?php include "footer.php"; ?>