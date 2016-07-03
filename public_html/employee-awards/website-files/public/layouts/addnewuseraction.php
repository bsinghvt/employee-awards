<?php
if(isset($_POST['submit'])){
	if(isset($_POST["user_email"]) && isset($_POST["password"]) && isset($_POST["signature"]) 
		&& isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["job_title"])) {

		$user_email=$_POST["user_email"];
		$password=$_POST["password"];
		$signature=$_POST["signature"];
		$first_name=$_POST["first_name"];
		$last_name=$_POST["last_name"];
		$job_title=$_POST["job_title"];
		$creation=date('Y-m-d H:i:s');
		$middle_name=$_POST["middle_name"];
		if (($_POST["middle_name"]==null))
		{
			$middle_name= "none";
		}	
	}
	else
	{
		$message = "Unable to register user as registration form was not completed";
	}
}	 
?>