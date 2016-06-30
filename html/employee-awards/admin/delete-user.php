<?php
require_once("../../../gallery-files/includes/initialize.php");
if(!$session->is_logged_in()) {redirect_to("login.php");}
get_template("admin-header.php");
?>
<?php 
if(isset($_GET['id'])){
	if(!empty($_GET['id'])){
		$photo = new PhotoGraph();
		$pic =& $photo->findById($_GET['id']);
		if($pic[0]->deleteById("../", $_GET['id'])){
			$session->message("Photo ".$pic[0]->filename." is deleted.");
			redirect_to("list-photos.php");
		}
		else{
			$session->message("Photo can not be deleted.");
			redirect_to("list-photos.php");
		}	
	}

	else{
		$session->message("Id is not provided.");
		 redirect_to("index.php");
	}
} else {
	$session->message("Id is not set.");
	 redirect_to("index.php");
}
?>
<?php if(isset($database)) {$database->close_connecion();} ?>
