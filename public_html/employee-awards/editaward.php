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
$adid=$_POST["adid"];
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

<form id="award-create" method="post" action="get_form_data.php">
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


<!-- Be able to upload photo of signature later after basic form works.
<label for="signature">Upload Your Signature</label>
<input type="button" name="signature">
-->


<input type="submit" name="submit" id="submit" value="Send Certificate" />

</fieldset>
</form>

</div><!-- /end #award-create-form -->

<?php get_template("footer.php"); 
 ?>
