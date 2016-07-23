<?php
$GLOBALS['added'] = false;
if(!empty($_POST)){
	if(isset($_POST["user_email"]) && isset($_POST["password"])) {
		
		if(trim($_POST["user_email"]) != "" && trim($_POST["password"]) != "") {
			$user = new Admin();
			$user->user_email=$_POST["user_email"];
			$user->password=password_hash($_POST["password"], PASSWORD_DEFAULT);
			if($user->add_new()){
				$GLOBALS['msg'] = '<p style="color:green;"> <b>New Admin is added successfully.</b></p>';
				$GLOBALS['added'] = true;
			}
			else{
				$GLOBALS['msg'] = '<p style="color:red;"> <b>'.$user->error.'</b></p>';
			}
		}
		else{
			$GLOBALS['msg'] = '<p style="color:red;"> <b>Please Enter all required fields.</b></p>';
		}
	}
	else
	{
		$GLOBALS['msg'] = '<p style="color:red;"> <b>Please Enter all required fields.</b></p>';
	}
}	 
?>