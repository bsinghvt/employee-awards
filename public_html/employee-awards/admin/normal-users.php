<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('file_uploads', 1);
require_once(__DIR__.'/../website-files/initialize.php');
?>
<?php 
$session->check_adm_login();
if(!$session->is_admin_logged_in()){
    redirect_to('login.php');
}
get_template("addnewuseraction.php");
get_template("admin-header.php");
if(isset($msg)){
	echo output_message($msg);
	unset($GLOBALS['msg']);
}
get_template("addnewuserform.php", $arr = Array("action" => "normal-users.php", "legend"=>"Add New User"));
?>
<img src="../website-files/public/layouts/getsignimage.php?id=5" width="10" height="100" />
<div id="normal-users">
                <p><h4>User List</h4></p>
            
                <table id="displaytable" class="table table-striped" cellspacing="0" width="100%" >
				<thead>
                    <tr>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Job Title</th>
                        <th>Last Updated Time</th>
						<th>Action</th>
                    </tr>
                </thead>
				<tfoot>
                    <tr>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Job Title</th>
                        <th>Last Updated Time</th>
						<th>Action</th>
                    </tr>
                </tfoot>
                <!-- PHP-->
<?php
    $data = [];
    $users = new User();
    if(!$data = $users->findAll()){
        echo '<p style="color:red;"><b>Error in database. The users cannot be displayed. Please try again</b></p';
    }?>
	<tbody>
   <?php foreach($data as $info): ?>
 <tr id="<?php echo $info->uid ?>">
     <td><?php echo $info->first_name; ?></td>
     <td><?php echo $info->middle_name; ?></td>
     <td><?php echo $info->last_name; ?></td>
     <td><?php echo $info->job_title; ?></td>
	 <td><?php echo $info->creation; ?></td>
	 <td><button name="delete" class="btn btn-default" onclick="deleteNormalUser(<?php echo $info->uid; ?>,'<?php echo "../website-files/public/layouts/deleteuser.php"; ?>')">Delete</button></td>
</tr>

<?php endforeach; ?>
</tbody>
                </table>
</div>
<?php get_template($template = "footer.php", $arr = array('script'=>'../public/javascripts/script.js')); ?>
