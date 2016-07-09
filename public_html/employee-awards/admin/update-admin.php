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
get_template("updateadminaction.php", Array('session'=>$session));
if(isset($_GET['id'])){
	$data = [];
    $admin = new Admin();
	$admin->admin_id = $_GET['id'];
    if(!$data = $admin->find_by_id()){
        echo '<p style="color:red;"><b>Error in database. The admin cannot be displayed. Please try again</b></p';
		return;
    }
	$info = $data[0];
	$admin_id = $info->admin_id;
	$user_email = $info->user_email;
	$pwd = $info->password; 
	get_template("admin-header.php");
	get_template('navbar.php', $arr = array('logoutLink'=>'login.php?logout=true','main'=>'index.php','sitename' =>'Green Arrow Consulting', 'navbar'=>array(array('link'=>'index.php', 'desc'=>'Home'), array('link'=>'normal-users.php', 'desc'=>'User Info'), array('link'=>'admin-users.php', 'desc'=>'Admin Info'), array('link'=>'awards.php', 'desc'=>'Awards'))));
	if(isset($GLOBALS['msg'])){
		echo output_message($GLOBALS['msg']);
		unset($GLOBALS['msg']);
	}
	if(isset($_SESSION['msg'])){
		echo output_message($_SESSION['msg']);
		unset($_SESSION['msg']);
	}
	get_template("addnewadminform.php", $arr = Array("action" => "update-admin.php", "legend"=>"Update Admin", "admin_id"=>$admin_id, "user_email"=>$user_email, "pwd"=>$pwd));
	get_template($template = "footer.php", $arr = array('script'=>'../public/javascripts/script.js', 'export_table'=>'../public/javascripts/jquery.table2excel.js')); 
}?>
