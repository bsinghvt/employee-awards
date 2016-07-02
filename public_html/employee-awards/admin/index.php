<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__.'/../website-files/initialize.php');
$session->check_adm_login();
if(!$session->is_admin_logged_in()) {redirect_to("login.php");}
get_template("admin-header.php");
?>
<?php get_template("footer.php"); 
 ?>
