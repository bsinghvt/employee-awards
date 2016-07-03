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
get_template("addnewuseraction.php");
get_template("admin-header.php");
if(isset($msg)){
	echo output_message($msg);
	unset($GLOBALS['msg']);
}
get_template("addnewuserform.php", $arr = Array("action" => "normal-users.php", "legend"=>"Add New User"));
?>
<div id="normal-users">
                <p><h4>All Normal Users</h4></p>
            
                <table id="dispnormalusers" class="table table-striped">
                    <tr>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Job Title</th>
                        <th>Last Updated Time</th>
                    </tr>
                
                <!-- PHP-->
<?php
    $data = [];
    $users = new User();
    if(!$data = $users->findAll()){
        echo '<p style="color:red;"><b>Error in database. The users cannot be displayed. Please try again</b></p';
    }
    foreach($data as $info): ?>
 <tr id="<?php echo $info->uid ?>">
     <td><?php echo $info->first_name; ?></td>
     <td><?php echo $info->middle_name; ?></td>
     <td><?php echo $info->last_name; ?></td>
     <td><?php echo $info->job_title; ?></td>
	 <td><?php echo $info->creation; ?></td>
</tr>

<?php endforeach; ?>
                </table>
</div>
<?php get_template($template = "footer.php"); ?>
