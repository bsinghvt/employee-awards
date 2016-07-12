<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
require_once(__DIR__.'/../website-files/initialize.php');
?>
<?php
if(!isset($_GET['id'])){
	return;
}
if(trim($_GET['id']) == ""){
	return;
}
if(!isset($_GET['name'])){
	return;
}
if(trim($_GET['name']) == ""){
	return;
}
$session->check_adm_login();
if(!$session->is_admin_logged_in()){
    redirect_to('login.php');
}
get_template("admin-header.php");
get_template('navbar.php', $arr = array('logoutLink'=>'login.php?logout=true', 'main'=>'index.php','sitename' =>'Green Arrow Consulting', 'navbar'=>array(array('link'=>'index.php', 'desc'=>'Home'), array('link'=>'normal-users.php', 'desc'=>'User Info'), array('link'=>'admin-users', 'desc'=>'Admin Info'), array('link'=>'awards.php', 'desc'=>'Awards'))));
if(isset($GLOBALS['msg'])){
	echo output_message($GLOBALS['msg']);
	unset($GLOBALS['msg']);
}
if(isset($_SESSION['msg'])){
	echo output_message($_SESSION['msg']);
	unset($_SESSION['msg']);
}
?>
<div id="admin-actions">
                <p><h4>Actions done by admin <?php echo trim($_GET['name']); ?></h4></p>
            
                <table id="displaytable" class="table table-striped">
				<thead>
                    <tr>
						<th>Actions</th>
						<th>Time Stamp</th>
                    </tr>
					</thead>
					<tfoot>
                    <tr class="noExl">
						<th>Actions</th>
						<th>Time Stamp</th>
                    </tr>
					</tfoot>
					<tbody>
<?php
    $data = [];
    $actions = new AdminActions();
	$actions->admin_id = trim($_GET['id']);
	$data = $actions->find_by_admin_id();
	if(!is_array($data)){
        echo '<p style="color:red;"><b>Error in database. The admin actions cannot be displayed. Please try again</b></p';
		return;
    }
	else if(empty($data)){
		echo '<p style="color:red;"><b>No actions performed by admin '.$_GET['name'].'</b></p';
		return;
	}
    foreach($data as $info): ?>
 <tr id="<?php echo $info->action_id ?>">
     <td><?php echo $info->action; ?></td>
	 <td><?php echo $info->action_timestamp; ?></td>
</tr>

<?php endforeach; ?>
</tbody>
                </table>
</div>
<?php get_template($template = "footer.php", $arr = array('script'=>'../public/javascripts/script.js', 'export_table'=>'../public/javascripts/jquery.table2excel.js')); ?>
