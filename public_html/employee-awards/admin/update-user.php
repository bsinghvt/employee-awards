<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__.'/../website-files/initialize.php');
?>
<?php 
$session->check_adm_login();
if(!$session->is_admin_logged_in()){
    redirect_to('login.php');
}
get_template("updateuseraction.php");
if(isset($_GET['uid'])){
	$data = [];
    $user = new User();
	$user->uid = $_GET['uid'];
    if(!$data = $user->find_by_id()){
        echo '<p style="color:red;"><b>Error in database. The users cannot be displayed. Please try again</b></p';
		return;
    }
	$info = $data[0];
	$uid = $info->uid;
	$user_email = $info->user_email;
    $first_name = $info->first_name;
    $middle_name = $info->middle_name;
    $last_name = $info->last_name;
    $job_title = $info->job_title;
    $signature = $info->signature; 
	$pwd = $info->password; 
	get_template("admin-header.php");
	get_template('navbar.php', $arr = array('logoutLink'=>'logout.php','main'=>'index.php','sitename' =>'Green Arrow Consulting', 'navbar'=>array(array('link'=>'index.php', 'desc'=>'Home'), array('link'=>'#', 'desc'=>'User Info'), array('link'=>'admin-users.php', 'desc'=>'Admin Info'), array('link'=>'awards.php', 'desc'=>'Awards'))));
	if(isset($GLOBALS['msg'])){
		echo output_message($GLOBALS['msg']);
		unset($GLOBALS['msg']);
	}
	if(isset($_SESSION['msg'])){
		echo output_message($_SESSION['msg']);
		unset($_SESSION['msg']);
	}
	get_template("addnewuserform.php", $arr = Array("action" => "update-user.php", "legend"=>"Update User", "uid"=>$uid, "first_name"=>$first_name,"middle_name"=>$middle_name,
												"user_email"=>$user_email,"last_name"=>$last_name,"job_title"=>$job_title, "signature"=>$signature, "pwd"=>$pwd));
	get_template($template = "footer.php", $arr = array('script'=>'../public/javascripts/script.js', 'export_table'=>'../public/javascripts/jquery.table2excel.js')); 
}?>
