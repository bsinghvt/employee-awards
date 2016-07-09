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
get_template("addnewadminaction.php");
get_template("admin-header.php");
get_template('navbar.php', $arr = array('logoutLink'=>'login.php?logout=true', 'main'=>'index.php','sitename' =>'Green Arrow Consulting', 'navbar'=>array(array('link'=>'index.php', 'desc'=>'Home'), array('link'=>'normal-users.php', 'desc'=>'User Info'), array('link'=>'#', 'desc'=>'Admin Info'), array('link'=>'awards.php', 'desc'=>'Awards'))));
if(isset($GLOBALS['msg'])){
	echo output_message($GLOBALS['msg']);
	unset($GLOBALS['msg']);
}
if(isset($_SESSION['msg'])){
	echo output_message($_SESSION['msg']);
	unset($_SESSION['msg']);
}
get_template("addnewadminform.php", $arr = Array("action" => "admin-users.php", "legend"=>"Add New Admin"));
?>
<div id="admin-users">
                <p><h4>Admin Users</h4></p>
            
                <table id="displaytable" class="table table-striped">
				<thead>
                    <tr>
                        <th>Email</th>
						<th># Actions</th>
						<th>Delete</th>
						<th>Update</th>
                    </tr>
					</thead>
					<tfoot>
                    <tr class="noExl">
                        <th>Email</th>
						<th># Actions</th>
						<th>Delete</th>
						<th>Update</th>
                    </tr>
					</tfoot>
					<tbody>
<?php
    $data = [];
    $users = new Admin();
    if(!$data = $users->findAll()){
        echo '<p style="color:red;"><b>Error in database. The admins cannot be displayed. Please try again</b></p';
    }
    foreach($data as $info): ?>
 <tr id="<?php echo $info->admin_id ?>">
     <td><?php echo $info->user_email; ?></td>
	 <td><a href="admin-actions.php?id=<?php echo $info->admin_id; ?>&name=<?php echo $info->user_email; ?>"><?php echo $info->total_actions; ?></a></td>
	  <td><button name="delete" class="btn btn-warning" onclick="deleteAdmin('<?php echo $info->user_email; ?>',<?php echo $info->admin_id; ?>,'<?php echo "../website-files/public/layouts/deleteadmin.php"; ?>')" >Delete Admin</button></td>
	   <td><a class="btn btn-info" role="button" href="update-admin.php?id=<?php echo $info->admin_id; ?>">Update Admin</a></td>
</tr>

<?php endforeach; ?>
</tbody>
                </table>
</div>
<?php get_template($template = "footer.php", $arr = array('script'=>'../public/javascripts/script.js', 'export_table'=>'../public/javascripts/jquery.table2excel.js')); ?>
