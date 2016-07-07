<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__.'/../website-files/initialize.php');
$session->check_adm_login();
if(!$session->is_admin_logged_in()) {redirect_to("login.php");}
get_template("admin-header.php");
get_template('navbar.php', $arr = array('logoutLink'=>'logout.php', 'main'=>'index.php','sitename' =>'Green Arrow Consulting', 'navbar'=>array(array('link'=>'#', 'desc'=>'Home'), array('link'=>'normal-users.php', 'desc'=>'User Info'), array('link'=>'admin-users.php', 'desc'=>'Admin Info'), array('link'=>'awards.php', 'desc'=>'Awards'))));
?>
  <div class="list-group">
                <a href="normal-users.php" class="list-group-item">Normal User's Information</a>
                <a href="admin-users.php" class="list-group-item">Admin User's Information</a>
                <a href="awards.php" class="list-group-item">Award's Information</a>
   </div>
<?php get_template("footer.php"); 
 ?>
