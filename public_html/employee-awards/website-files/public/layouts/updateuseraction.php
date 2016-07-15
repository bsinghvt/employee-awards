<?php
$session->check_adm_login();
if(!$session->is_admin_logged_in()){
    redirect_to('login.php');
}
if(!empty($_POST)){
	if(isset($_POST["user_email"]) && isset($_POST["password"])
		&& isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["job_title"]) && isset($_POST["uid"]) && isset($_POST["sign"])) {
		
		if(trim($_POST["user_email"]) != "" && trim($_POST["password"]) != "" && trim($_POST["uid"]) != ""
		&& trim($_POST["first_name"]) != "" && trim($_POST["last_name"]) != "" && trim($_POST["job_title"]) != "" && trim($_POST["sign"]) != "") {
			if (isset($_FILES['signature']) && $_FILES['signature']['size'] > 0){
				if($_FILES['signature']['size'] > 204800){
					$_SESSION['msg'] = '<p style="color:red;"> <b>Error: Image of your signature cannot be greater than 200KB.</b></p>';
					return;
				}
				$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
				$detectedType = exif_imagetype($_FILES['signature']['tmp_name']);
				if(!in_array($detectedType, $allowedTypes)){
					$_SESSION['msg'] = '<p style="color:red;"> <b>Error: Only JPG, JPEG, PNG & GIF files are allowed for signature.</b></p>';
					return;
				}
				$image_check = getimagesize($_FILES['signature']['tmp_name']);
				if($image_check==false)
				{
					$_SESSION['msg'] = '<p style="color:red;"> <b>Error: Please upload a valid image of your signature.</b></p>';
					return;
				}
				$file_name = uniqid(); //basename($_FILES['signature']['name']); //$data = file_get_contents($_FILES['signature']['tmp_name']);
				$temp_path = $_FILES['signature']['tmp_name'];
				$target_path = SIG_IMAGES.DS.$file_name;
				$delete_path = SIG_IMAGES.DS.$_POST["sign"];
				//Check if file already exists
				if(file_exists($target_path)){
					$_SESSION['msg'] = '<p style="color:red;"> <b>Error: Please try again.</b></p>';
					return;
				}
				if(!move_uploaded_file($temp_path, $target_path)){
					$_SESSION['msg'] = '<p style="color:red;"> <b>Error: Please try again.</b></p>';
					return;
				}
				$user = new User();
				$user->uid = $_POST["uid"];
				$user->user_email=$user_email=$_POST["user_email"];
				$user->password=$pwd=$_POST["password"];
				$user->signature=$file_name;
				$user->first_name=$first_name=$_POST["first_name"];
				$user->last_name=$last_name=$_POST["last_name"];
				$user->job_title=$job_title=$_POST["job_title"];
				$user->middle_name=$middle_name=$_POST["middle_name"];
				if($user->update()){
					$_SESSION['msg'] = '<p style="color:green;"> <b>User is updated successfully.</b></p>';
					$admin_action = new AdminActions();
					$admin_action->admin_id = $session->admin_id;
					$admin_action->action = 'Admin '.$session->admin_username.' updated '.$_POST["user_email"];
					$admin_action->add_new();
					unset($_POST);
					if(file_exists($delete_path)){
						unlink($delete_path);
					}
					redirect_to('normal-users.php');
				}
				else{
					$_SESSION['msg'] = '<p style="color:red;"> <b>'.$user->error.' while updating</b></p>';
					unlink($target_path);
				}
			}
			else{
				$_SESSION['msg'] = '<p style="color:red;"> <b>Please upload a valid image of your signature.</b></p>';
			}
		}
		else{
			$_SESSION['msg'] = '<p style="color:red;"> <b>Please Enter all required fields.</b></p>';
		}
	}
	else
	{
		$_SESSION['msg'] = '<p style="color:red;"> <b>Please Enter all required fields.</b></p>';
	}
	redirect_to('update-user.php?uid='.$_POST["uid"]);
}	 
?>