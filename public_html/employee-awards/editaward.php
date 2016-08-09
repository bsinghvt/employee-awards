<?php
require_once(__DIR__.'/website-files/initialize.php');
//ob_start(); //from stack overflow
include 'pass.php';
error_reporting(E_ALL);
ini_set('display_errors','On');
//session_start();
if (!isset($_SESSION["user_email"]))
{
    header("Location: login.php", true);
}
get_template("header.php");
get_template("nav2.php");
/*
if (isset($_SESSION["new_award"]))
{
	if ($_SESSION["new_award"]==1)
	{
		echo "Award succesfully created";
		$_SESSION["new_award"]=0;
	}
	else if ($_SESSION["new_award"]==-1)
	{
		echo "Error in creating Award";
		$_SESSION["new_award"]=0;
	}

}
*/
include 'pass.php';
$adid=$_SESSION['adid'];
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "harrings-db", $pass, "harrings-db");
    if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	if (!($stmt = $mysqli->prepare("SELECT award_type, recepient_email, r_first_name, r_middle_name, r_last_name, granted, public From Award WHERE adid=?"))) {
     echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$stmt->bind_param("i", $adid)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}
if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
$stmt->bind_result($award_type, $r_email, $r_first_name, $r_middle_name, $r_last_name, $granted, $public);

    
    $stmt->fetch();
$stmt->close();
?>


<div id="award-create-form">    

<form id="award-create" method="post" action="editawardinfo.php">
<fieldset>    
<label>Input the following information about the award</label>
<br>
<label for="award-type">Title of Award</label>
<input type="text" name="award-type" value="<?php echo htmlspecialchars($award_type); ?>">
<br>
<label for="date">Date that Award is Given</label>
<input type="date" name="date" value="<?php echo htmlspecialchars($granted); ?>">
<br>
<label>Public Awards can be viewed by anyone while private awards can only be viewed by recepeint</label>
<?php if ($public==1)
{ ?>
<input type="radio" name="public" value="public" checked> Public<br>
<input type="radio" name="public" value="private"> Private<br>
<br>
<?php
}
else
{ ?>
<input type="radio" name="public" value="public"> Public<br>
<input type="radio" name="public" value="private" checked> Private<br>
<br>
<?php } ?>
<label>Input the following information about the award recipient below:</label>
<br>
<label for="r-first-name">First Name</label>
<input type="text" name="r-first-name" value="<?php echo htmlspecialchars($r_first_name); ?>">
<br>
<label for="r-middle-name">Middle Name</label>
<input type="text" name="r-middle-name" value="<?php echo htmlspecialchars($r_middle_name); ?>">
<br>
<label for="r-last-name">Last Name</label>
<input type="text" name="r-last-name" value="<?php echo htmlspecialchars($r_last_name); ?>">
<br>
<label for="r-email">Award Recipient's E-mail</label>
<input type="email" name="r-email" value="<?php echo htmlspecialchars($r_email); ?>">
<br>
<?php 	echo "<input type=\"hidden\" name=\"adid\" value=\"".$adid."\">"; ?>


<!-- Be able to upload photo of signature later after basic form works.
<label for="signature">Upload Your Signature</label>
<input type="button" name="signature">
-->
<p><i><font color="blue">Use the browser's back button after previewing to edit and/or send certificate.</font></i></p>
<br>
<input type="submit" name="preview" id="preview" value="Preview Certificate" />
<br><br>

<input type="submit" name="send" id="send" value="Update Award and Send Certificate" />

</fieldset>
</form>

</div><!-- /end #award-create-form -->

<script>

	jQuery.validator.addMethod("noSpace", function(value, element) {
		trim_value = jQuery.trim(value);
		return trim_value != ""; //value.indexOf(" ") < 0 && value != ""; 
	}, " No blank spaces please");


	$("#award-create").validate({
		rules: {
	            'award-type': {
	                maxlength: 25,
	            	noSpace: true
	            },
	            'r-first-name': {
	      			noSpace: true
	    		},
	      //       'r-middle-name': {
	      // 			noSpace: true
	    		// },
	            'r-last-name': {
	      			noSpace: true
	    		},
	            'r-email': {
	      			noSpace: true
	    		}
	        }
	});

</script>

<?php
if (isset($_SESSION["new_award"]))
{
	if ($_SESSION["new_award"]==1)
	{
		?>
		<script>
			document.getElementById('message').innerHTML = "<span style='color:#00cc00'>Certificate Sent!</span>";
		</script>
		<?php
		//echo '<strong><font color="green">Award succesfully created and sent!</font></strong>';
		$_SESSION["new_award"]=0;
	}
	else if ($_SESSION["new_award"]==-1)
	{
		?>
		<script>
			document.getElementById('message').innerHTML = "<span style='color:#cc0000'>Error in creating award. </span>";
		</script>
		<?php
		//echo "Error in creating Award";
		$_SESSION["new_award"]=0;
	}
}
?>

<?php get_template("footer.php"); 
 ?>

<script type="text/javascript">
	

</script>
