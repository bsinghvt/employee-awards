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
get_template('navbar.php', $arr = array('logoutLink'=>'login.php?logout=true','main'=>'index.php','sitename' =>'Green Arrow Consulting', 'navbar'=>array(array('link'=>'index.php', 'desc'=>'Home'), array('link'=>'#', 'desc'=>'User Info'), array('link'=>'admin-users.php', 'desc'=>'Admin Info'), array('link'=>'awards.php', 'desc'=>'Awards'))));
if(isset($GLOBALS['msg'])){
	echo output_message($GLOBALS['msg']);
	unset($GLOBALS['msg']);
}
if(isset($_SESSION['msg'])){
	echo output_message($_SESSION['msg']);
	unset($_SESSION['msg']);
}
get_template("addnewuserform.php", $arr = Array("action" => "normal-users.php", "legend"=>"Add New User"));
?>
<div id="msg"></div>
<img src="../website-files/public/layouts/getsignimage.php?id=5" width="10" height="100" />
<div id="normal-users">
                <p><h4>User List</h4></p>
				<form style="border:none;">
    <div class="form-group">
      <div class="col-xs-6">
        <label for="minaward">Minimum Awards Created:</label>
        <input class="form-control" id="minaward" type="number" placeholder="0">
      </div>
      <div class="col-xs-6">
        <label for="maxaward">Maximum Awards Created:</label>
        <input class="form-control" id="maxaward" type="number" placeholder="5000">
      </div>
    </div>
  </form>
  			<form style="border:none;">
    <div class="form-group">
      <div class="col-xs-6">
        <label for="mindate">User Added/Update After:</label>
        <input class="form-control" id="mindate" type="date" value="1970-01-31">
      </div>
	  <div class="col-xs-6">
        <label for="maxdate">User Added/Update Before:</label>
        <input class="form-control" id="maxdate" type="date" value="2070-01-31">
      </div>
    </div>
  </form>
  <button id="filterdata" name="filter" class="btn btn-success">Filter</button>
                <table id="displaytable" class="table table-striped">
				<thead>
                    <tr>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Job Title</th>
						<th># Awards Created</th>
                        <th>Add/Update Date</th>
						<th>Delete</th>
						<th>Update</th>
                    </tr>
                </thead>
				<tfoot>
                    <tr class="noExl">
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Job Title</th>
						<th># Awards Created</th>
                        <th>Add/Update Date</th>
						<th>Delete</th>
						<th>Update</th>
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
 <tr class="data" id="<?php echo $info->uid ?>">
     <td><?php echo $info->first_name; ?></td>
     <td><?php echo $info->middle_name; ?></td>
     <td><?php echo $info->last_name; ?></td>
     <td><?php echo $info->job_title; ?></td>
	 <td><?php echo $info->total_awards; ?></td>
	 <td><?php echo date_format(date_create($info->creation), 'm/d/Y'); ?></td>
	 <td >
		<button name="delete" class="btn btn-warning" onclick="deleteNormalUser('<?php echo $info->user_email; ?>',<?php echo $info->uid; ?>,'<?php echo "../website-files/public/layouts/deleteuser.php"; ?>')">Delete User</button>
	 </td>
	 <td>
		<a class="btn btn-info" role="button" href="update-user.php?uid=<?php echo $info->uid; ?>">Update user</a>
	 </td>
</tr>

<?php endforeach; ?>
</tbody>
                </table>
				<button id="exportsheet" class="btn btn-success">Export list as excel sheet</button>
</div>
<?php get_template($template = "footer.php", $arr = array('script'=>'../public/javascripts/script.js', 'export_table'=>'../public/javascripts/jquery.table2excel.js')); ?>
