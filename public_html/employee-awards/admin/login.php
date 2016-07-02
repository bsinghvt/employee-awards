<?php
require_once("../../../website-files/includes/initialize.php");
if($session->is_logged_in()) {redirect_to("index.php");}
$message = "";
if(isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $found_user = Admin::authenticate($username, $password);
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
get_template("admin-header.php");
echo output_message($message); 
?>

<div class="form-group">
    <form method="post" action="login.php"> 
        <fieldset>
            <legend>Staff Login</legend>
            <p>Username: <input type="text" name="username" class="form-control" maxlength="30" value="<?php echo htmlentities($username); ?>"/></p>
            <p>Password: <input type="password" name="password" class="form-control" maxlength="30" value="<?php echo htmlentities($password); ?>"/></p>
            <p><input type="submit" name="submit" class="btn btn-default" value="Login"/></p>
        </fieldset>
    </form>
</div>
<?php get_template($template = "footer.php"); ?>
