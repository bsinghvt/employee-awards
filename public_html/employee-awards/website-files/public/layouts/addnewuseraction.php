<?php
$GLOBALS['added'] = false;
if(!empty($_POST)){
	if(isset($_POST["user_email"]) && isset($_POST["password"])
		&& isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["job_title"])) {
		
		if(trim($_POST["user_email"]) != "" && trim($_POST["password"]) != ""
		&& trim($_POST["first_name"]) != "" && trim($_POST["last_name"]) != "" && trim($_POST["job_title"]) != "") {
			if (isset($_FILES['signature']) && $_FILES['signature']['size'] > 0){
				if($_FILES['signature']['size'] > 204800){
					$GLOBALS['msg'] = '<p style="color:red;"> <b>Error: Image of your signature cannot be greater than 200KB.</b></p>';
					return;
				}
				$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
				$extension = array(IMAGETYPE_PNG=>'.png', IMAGETYPE_JPEG=>'.jpg', IMAGETYPE_GIF=>'.gif');
				$detectedType = exif_imagetype($_FILES['signature']['tmp_name']);
				if(!in_array($detectedType, $allowedTypes)){
					$GLOBALS['msg'] = '<p style="color:red;"> <b>Error: Only JPG, JPEG, PNG & GIF files are allowed for signature.</b></p>';
					return;
				}
				$image_check = getimagesize($_FILES['signature']['tmp_name']);
				if($image_check==false)
				{
					$GLOBALS['msg'] = '<p style="color:red;"> <b>Error: Please upload a valid image of your signature.</b></p>';
					return;
				}
				$file_name = uniqid().$extension[$detectedType]; //basename($_FILES['signature']['name']); //$data = file_get_contents($_FILES['signature']['tmp_name']);
				$temp_path = $_FILES['signature']['tmp_name'];
				$target_path = SIG_IMAGES.DS.$file_name;
				//Check if file already exists
				if(file_exists($target_path)){
					$GLOBALS['msg'] = '<p style="color:red;"> <b>Error: Please try again.</b></p>';
					return;
				}
				if(move_uploaded_file($temp_path, $target_path)){
					$user = new User();
					$user->user_email=$user_email=$_POST["user_email"];
					$user->password=$pwd=password_hash($_POST["password"], PASSWORD_DEFAULT);
					$user->signature=$file_name;
					$user->first_name=$first_name=$_POST["first_name"];
					$user->last_name=$last_name=$_POST["last_name"];
					$user->job_title=$job_title=$_POST["job_title"];
					$user->middle_name=$middle_name=$_POST["middle_name"];
					if($user->add_new()){
						$GLOBALS['msg'] = '<p style="color:green;"> <b>New User is added successfully.</b></p>';
						$GLOBALS['added'] = true;
					}
					else{
						$GLOBALS['msg'] = '<p style="color:red;"> <b>'.$user->error.'</b></p>';
						unlink($target_path);
					}
				}
				else{
					$GLOBALS['msg'] = '<p style="color:red;"> <b>Error: Please try again.</b></p>';
					return;
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
	else{
		$GLOBALS['msg'] = '<p style="color:red;"> <b>Please Enter all required fields.</b></p>';
	}
}	 
?>