<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
require_once(__DIR__.'/../website-files/initialize.php');
?>
<?php
if(isset($_GET['logout'])){
	if($_GET['logout'] === 'true'){
		$session->admin_logout();
	}
}
$session->check_adm_login();
if($session->is_admin_logged_in()){
    redirect_to('index.php');
} 
$msg = "";
    if(isset($_POST["username"]) && isset($_POST["password"])){
        $user_name = $_POST["username"];
        $pwd = $_POST["password"];
        if(trim($user_name) != "" && trim($pwd) != ""){
            $user = new Admin();
            $user->user_email = $user_name;
            if($user->authenticate($pwd)){
                $session->login_admin($user);
                redirect_to('index.php');
            }
            else{
                $msg = '<p style="color:red;"> <b>Invalid Login: Username or password wrong.</b></p>';
            }
        }
        else{
            $msg = '<p style="color:red;"> <b>Please Enter username/password field.</b></p>';
        }
    }
get_template("admin-header.php");
echo output_message($msg); 
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
     <p><small>Login as User <a href="../index.php"> Here.</a></small></p>
</div>
<?php get_template($template = "footer.php"); ?>
