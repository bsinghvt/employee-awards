<?php
require_once(__DIR__.'/website-files/includes/initialize.php');
if($session->is_logged_in()) {redirect_to("index.php");}
$message = "";
if(isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $found_user = User::authenticate($username, $password);
    if($found_user) {
        $session->login($found_user);
        log_actions('Login', "{$found_user->username} logged in.");
        redirect_to("index.php");
    } else {
        $message = "Username/password combination incorrect.";
    }
} else {
    $username = "";
    $password = "";
}
get_template("header.php");
echo output_message($message); 
?>

<div class="form-group">
    <form method="post" action="login.php"> 
        <fieldset>
            <legend>Login</legend>
            <p>Username: <input type="text" name="username" class="form-control" maxlength="30" value="<?php echo htmlentities($username); ?>"/></p>
            <p>Password: <input type="password" name="password" class="form-control" maxlength="30" value="<?php echo htmlentities($password); ?>"/></p>
            <p><input type="submit" name="submit" class="btn btn-default" value="Login"/></p>
        </fieldset>
	 </form>
<p>Not Registered? <a href="register.php"> Register Here.</a></p>
</div>
<?php get_template($template = "footer.php"); ?>
