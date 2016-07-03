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
if(isset($msg)){
	echo output_message($msg);
	unset($GLOBALS['msg']);
}
get_template("addnewadminform.php", $arr = Array("action" => "admin-users.php", "legend"=>"Add New Admin"));
get_template("admin-header.php");

?>
<div id="admin-users">
                <p><h4>Admin Users</h4></p>
            
                <table id="dispadmins" class="table table-striped">
                    <tr>
                        <th>Email</th>
                    </tr>
                
                <!-- PHP-->
<?php
    $data = [];
    $users = new Admin();
    if(!$data = $users->findAll()){
        echo '<p style="color:red;"><b>Error in database. The admins cannot be displayed. Please try again</b></p';
    }
    foreach($data as $info): ?>
 <tr id="<?php echo $info->admin_id ?>">
     <td><?php echo $info->user_email; ?></td>
</tr>

<?php endforeach; ?>
                </table>
</div>
<?php get_template($template = "footer.php"); ?>
