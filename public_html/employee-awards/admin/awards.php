<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
require_once(__DIR__.'/../website-files/initialize.php');
?>
<?php 
$session->check_adm_login();
if(!$session->is_admin_logged_in()){
    redirect_to('login.php');
}
$GLOBALS['added'] = false;
get_template("admin-header.php");
get_template('navbar.php', $arr = array('logoutLink'=>'login.php?logout=true', 'main'=>'index.php','sitename' =>'Green Arrow Consulting', 'navbar'=>array(array('link'=>'index.php', 'desc'=>'Home'), array('link'=>'normal-users.php', 'desc'=>'User Info'), array('link'=>'admin-users.php', 'desc'=>'Admin Info'), array('link'=>'#', 'desc'=>'Awards'))));
if(isset($GLOBALS['msg'])){
	echo output_message($GLOBALS['msg']);
	if($GLOBALS['added'] == true){
		$admin_action = new AdminActions();
		$admin_action->admin_id = $session->admin_id;
		$admin_action->action = 'Admin '.$session->admin_username.' added new admin '.$_POST["user_email"];
		$admin_action->add_new();
	}
	unset($GLOBALS['added']);
	unset($GLOBALS['msg']);
}
if(isset($_SESSION['msg'])){
	echo output_message($_SESSION['msg']);
	unset($_SESSION['msg']);
}
?>
<p><form style="border:none;">
	<legend>Display awards received between</legend>
		<div class="form-group">
			<div class="col-xs-6">
				<label for="mindate">Start Date:</label>
				<input class="form-control" id="mindate" type="date" value="2016-01-31">
			</div>
			<div class="col-xs-6">
				<label for="maxdate">End Date:</label>
				<input class="form-control" id="maxdate" type="date" value="2018-01-31">
			</div>
		</div>
</form></p>
<br><br>
<div class="list-group">
                <button id="dispallawards" class="list-group-item">Display All Awards</button>
				<button id="dispawardsbyrec" class="list-group-item">Display Awards Group by Recipient</button>
				<button id="dispawardsbygiver" class="list-group-item">Display Awards Group by Award Giver</button>
				<button id="dispawardsbytype" class="list-group-item">Display Awards Group by Award Type</button>
</div>
<div id="awards">
     
</div>
<?php get_template($template = "footer.php", $arr = array('script'=>'../public/javascripts/script.js', 'export_table'=>'../public/javascripts/jquery.table2excel.js')); ?>
