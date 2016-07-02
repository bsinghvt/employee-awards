<?php
require_once(__DIR__.'/website-files/initialize.php');
if($session->is_logged_in()) {redirect_to("index.php");}
?>
<?php 
$session->check_user_login();
if($session->is_logged_in()){
    redirect_to('index.php');
} 
$msg = "";
    if(isset($_POST["username"]) && isset($_POST["password"])){
        $user_name = $_POST["username"];
        $pwd = $_POST["password"];
        if(trim($user_name) != "" && trim($pwd) != ""){
            $user = new User();
            $user->user_email = $user_name;
            $user->password = $pwd;
            if($user->authenticate()){
                $session->login($user);
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
get_template("header.php");
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
<p>Not Registered? <a href="register.php"> Register Here.</a></p>
</div>
<?php get_template($template = "footer.php"); ?>
