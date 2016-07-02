<?php
require_once(__DIR__.'/website-files/initialize.php');
$session->check_user_login();
if(!$session->is_logged_in()) {redirect_to("login.php");}
get_template("header.php");
?>
<?php get_template("footer.php"); 
 ?>
