<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__.'/website-files/includes/initialize.php');
if(isset($_POST['submit'])) {
    $username = trim($_POST['username']);
	 $password = trim($_POST['password']);
	 $firstname = trim($_POST['firstname']);
	 $lastname = trim($_POST['lastname']);
    if(!isset($username) || !isset($password) || !isset($firstname) || !isset($lastname) || empty($username) || empty($password) || empty($firstname) || empty($lastname)) {
		 $message = "Registeration Failed. Please enter all the fields correctly.";
		 unset($_POST['submit']);
	 } else {
		 $newUser = new User();
		 $newUser->username = $username;
		 $newUser->password = $password;
		 $newUser->first_name = $firstname;
		 $newUser->last_name = $lastname;
		 if($newUser->createUser()){
			 $session->message = "Registration is successfull";
			 log_actions('Registration', "{$username} registered.");
			 unset($_POST['submit']);
			 redirect_to("login.php");		 
		 } else {
			 $message = "Registration Failed. ".$newUser->error;
			 unset($_POST['submit']);
		 }
    }
} 
get_template("header.php");
echo output_message($message); 
?>

<div class="form-group">
    <form method="post" action="register.php"> 
        <fieldset>
				<legend>Registration</legend>
				<p>First Name: <input type="text" name="firstname" class="form-control" maxlength="30"/></p>
            <p>Last Name: <input type="text" name="lastname" class="form-control" maxlength="30"/></p>
            <p>Username: <input type="text" name="username" class="form-control" maxlength="30"/></p>
            <p>Password: <input type="password" name="password" class="form-control" maxlength="30"/></p>
            <p><input type="submit" name="submit" class="btn btn-default" value="Register"/></p>
        </fieldset>
	 </form>
</div>
<?php get_template($template = "footer.php"); ?>
