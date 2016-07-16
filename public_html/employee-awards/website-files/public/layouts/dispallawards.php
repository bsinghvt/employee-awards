<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__.'/../../initialize.php');
$session->check_adm_login();
if(!$session->is_admin_logged_in()){
    echo "unauthorized access";
	return;
}
if(!isset($_POST['mindate']) || !isset($_POST['maxdate'])){
	return;
}

if(trim($_POST['mindate']) == "" || trim($_POST['maxdate']) == ""){
	return;
}*/
?>

 <p><h4>All Awards</h4></p>
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
	$awards->min_date = $min_date;
	$awards->max_date = $max_date;
	$data = $awards->findAll();
    if(!is_array($data)){
        echo '<p style="color:red;"><b>Error in database. The awards cannot be displayed. Please try again</b></p';
		return;
    }
	else if(empty($data)){
		echo '<p style="color:red;"><b>No data to display. Please try again by changing filters.</b></p';
		return;
	}?>
	<tbody>
   <?php foreach($data as $info): ?>
 <tr class="data" >
	<td><?php echo $info->r_full_name(); ?></td>
     <td><?php echo $info->recepient_email(); ?></td>
     <td><?php echo $info->g_full_name(); ?></td>
     <td><?php echo $info->user_email(); ?></td>
     <td><?php echo $info->g_job_title(); ?></td>
     <td><?php echo date_format(date_create($info->granted), 'm/d/Y'); ?></td>
     <td><?php echo $info->award_type; ?></td>
</tr>

<?php endforeach; ?>
</tbody>
                </table>
				<button id="exportsheet" class="btn btn-success">Export list as excel sheet</button>