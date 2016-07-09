<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__.'/../../initialize.php');
$session->check_adm_login();
if(!$session->is_admin_logged_in()){
    echo "unauthorized access";
	return;
}
$_POST['mindate'] = '2016-01-31';
$_POST['maxdate'] = '2017-01-31';
if(!isset($_POST['mindate']) || !isset($_POST['maxdate'])){
	return;
}

if(trim($_POST['mindate']) == "" || trim($_POST['maxdate']) == ""){
	return;
}
?>

 <p><h4>All Awards</h4></p>
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
        <label for="mindate">User Added/Updated After:</label>
        <input class="form-control" id="mindate" type="date" value="2016-01-31">
      </div>
	  <div class="col-xs-6">
        <label for="maxdate">User Added/Updated Before:</label>
        <input class="form-control" id="maxdate" type="date" value="2018-01-31">
      </div>
    </div>
  </form>
  <button id="filterdata" name="filter" class="btn btn-success">Filter</button>
                <table id="displaytable" class="table table-striped">
				<thead>
                    <tr>
                        <th>Recipient Full Name</th>
                        <th>Recipient Email</th>
                        <th>Award Giver Full Name</th>
						<th>Award Giver Email</th>
                        <th>Award Giver Job Title</th>
						<th>Award Granted Date</th>
                        <th>Award Type</th>
                    </tr>
                </thead>
				<tfoot>
                    <tr class="noExl">
                        <th>Recipient Full Name</th>
                        <th>Recipient Email</th>
                        <th>Award Giver Full Name</th>
						<th>Award Giver Email</th>
                        <th>Award Giver Job Title</th>
						<th>Award Granted Date</th>
                        <th>Award Type</th>
                    </tr>
                </tfoot>
                <!-- PHP-->
<?php
    $data = [];
    $awards = new Award();
	$awards->min_date = $_POST['mindate'];
	$awards->max_date = $_POST['maxdate'];
    if(!$data = $awards->findAll()){
        echo '<p style="color:red;"><b>Error in database. The awards cannot be displayed. Please try again</b></p';
		return;
    }?>
	<tbody>
   <?php foreach($data as $info): ?>
 <tr class="data" id="<?php echo $info->adid ?>">
	<td><?php echo $info->r_full_name(); ?></td>
     <td><?php echo $info->recepient_email; ?></td>
     <td><?php echo $info->g_full_name(); ?></td>
     <td><?php echo $info->user_email; ?></td>
     <td><?php echo $info->job_title; ?></td>
     <td><?php echo date_format(date_create($info->granted), 'm/d/Y'); ?></td>
     <td><?php echo $info->award_type; ?></td>
</tr>

<?php endforeach; ?>
</tbody>
                </table>
				<button id="exportsheet" class="btn btn-success">Export list as excel sheet</button>