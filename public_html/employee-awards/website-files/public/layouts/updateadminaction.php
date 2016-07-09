<?php
$session->check_adm_login();
if(!$session->is_admin_logged_in()){
    redirect_to('login.php');
}
if(!empty($_POST)){
	if(isset($_POST["user_email"]) && isset($_POST["password"]) && isset($_POST["id"])) {
		if(trim($_POST["user_email"]) != "" && trim($_POST["password"]) != "" && trim($_POST["id"]) != "") {
			$admin = new Admin();
			$admin->admin_id = $_POST["id"];
			$admin->user_email=$user_email=$_POST["user_email"];
			$admin->password=$pwd=$_POST["password"];
			if($admin->update()){
				$_SESSION['msg'] = '<p style="color:green;"> <b>Admin is updated successfully.</b></p>';
				$admin_action = new AdminActions();
				$admin_action->admin_id = $session->admin_id;
				$admin_action->action = 'Admin '.$session->admin_username.' updated Admin '.$_POST["user_email"];
				$admin_action->add_new();
				unset($_POST);
				redirect_to('admin-users.php');
			}
			else{
				$_SESSION['msg'] = '<p style="color:red;"> <b>'.$admin->error.' while updating</b></p>';
			}
		}
		else{
			$_SESSION['msg'] = '<p style="color:red;"> <b>Please Enter all required fields.</b></p>';
		}
	}
	else{
		$_SESSION['msg'] = '<p style="color:red;"> <b>Please Enter all required fields.</b></p>';
	}
	redirect_to('update-admin.php?id='.$_POST["id"]);
}	 
?>