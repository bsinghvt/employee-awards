<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__.'/website-files/initialize.php'); 
get_template("header.php");
echo output_message($message); 
?>

<div class="form-group">
    <form method="post" action="createuser.php"> 
        <fieldset>
				<legend>Registration</legend>
				<p>User email (will be username): <input type="email" name="user_email" required /></p>
		<p>Password: <input type="password" name="password" required /></p>
		<p>First name: <input type="text" name="first_name" required /></p>
		<p>Middle name (optional): <input type="text" name="middle_name" /></p>
		<p>Last name: <input type="text" name="last_name" required /></p>
		<p>Job Title: <input type="text" name="job_title" required /></p>
		<p>Signature:  <input type="file" name="signature" accept="image/*" required/> </p>
		<br><br>
		<input type="submit" value="Submit">
        </fieldset>
	 </form>
</div>
<?php get_template($template = "footer.php"); ?>
