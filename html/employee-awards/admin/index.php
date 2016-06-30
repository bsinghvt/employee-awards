<?php
require_once("../../../gallery-files/includes/initialize.php");
if(!$session->is_logged_in()) {redirect_to("login.php");}
get_template("admin-header.php");
?>
<h4>Menu</h4>
<p><a href="logfile.php">View log File</a></p>
<?php get_template("footer.php"); ?>
