<?php
if(!empty($_POST)){
	if(isset($_POST["user_email"]) && isset($_POST["password"]) && isset($_POST["signature"])
		&& isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["job_title"])) {
		
		if(trim($_POST["user_email"]) != "" && trim($_POST["password"]) != "" && trim($_POST["signature"]) != ""
		&& trim($_POST["first_name"]) != "" && trim($_POST["last_name"]) != "" && trim($_POST["job_title"]) != "") {
			$user = new User();
			$user->user_email=$_POST["user_email"];
			$user->password=$_POST["password"];
			$user->signature=$_POST["signature"];
			$user->first_name=$_POST["first_name"];
			$user->last_name=$_POST["last_name"];
			$user->job_title=$_POST["job_title"];
			$user->middle_name=$_POST["middle_name"];
			if($user->add_new()){
				$GLOBALS['msg'] = '<p style="color:green;"> <b>New User is added successfully.</b></p>';
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