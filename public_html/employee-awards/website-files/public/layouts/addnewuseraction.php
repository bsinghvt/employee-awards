<?php
if(!empty($_POST)){
	if(isset($_POST["user_email"]) && isset($_POST["password"])
		&& isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["job_title"])) {
		
		if(trim($_POST["user_email"]) != "" && trim($_POST["password"]) != ""
		&& trim($_POST["first_name"]) != "" && trim($_POST["last_name"]) != "" && trim($_POST["job_title"]) != "") {
			if (isset($_FILES['signature']) && $_FILES['signature']['size'] > 0){ 
				$data = file_get_contents($_FILES['signature']['tmp_name']);
				$image_check = getimagesize($_FILES['signature']['tmp_name']);
				if($image_check==false)
				{
					$GLOBALS['msg'] = '<p style="color:red;"> <b>Please upload a valid image of your signature.</b></p>';
					return;
				}
				$user = new User();
				$user->user_email=$_POST["user_email"];
				$user->password=$_POST["password"];
				$user->signature=$data;
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
				$GLOBALS['msg'] = '<p style="color:red;"> <b>Please upload a valid image of your signature.</b></p>';
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