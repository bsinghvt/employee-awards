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
<h1><a href="usercreate.php">Creeate User Account</a></h1>
<br><h1><a href="login.php">User Login</a></h1>
<br><h1><a href="adminlogin.php">Admin Login</a></h1>
<br><h1><a href="forgot.php">Forgot Password</a></h1>

</section>	
</body>
</html>

<?php
}
?>
<?php include "footer.php"; ?>