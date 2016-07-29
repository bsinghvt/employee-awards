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

?>
<link rel="stylesheet" type="text/css" href="jquery-validation/demo/css/cmxform.css"> <!-- Stylesheets that came with the plugin demo -->
<script src="jquery-validation/lib/jquery.js"></script> 
<script src="jquery-validation/dist/jquery.validate.js"></script> <!-- the plugin for easy validation with jquery -->



<div id="award-create-form">    

<form id="award-create" method="post" action="get_form_data.php">
<fieldset>    
<label>Input the following information about the award</label>
<br>
<label for="award-type">Title of Award</label>
<input type="text" name="award-type" required>
<br>
<label for="date">Date that Award is Given</label>
<input type="date" name="date" required>
<br>
<label>Public Awards can be viewed by anyone while private awards can only be viewed by recepeint</label>
<input type="radio" name="public" value="public" checked> Public<br>
<input type="radio" name="public" value="private" checked> Private<br>
<br>
<label>Input the following information about the award recipient below:</label>
<br>
<label for="r-first-name">First Name</label>
<input type="text" name="r-first-name" required>
<br>
<label for="r-middle-name">Middle Name</label>
<input type="text" name="r-middle-name">
<br>
<label for="r-last-name">Last Name</label>
<input type="text" name="r-last-name" required>
<br>
<label for="r-email">Award Recipient's E-mail</label>
<input type="email" name="r-email" required>
<br><br>


<!-- Be able to upload photo of signature later after basic form works.
<label for="signature">Upload Your Signature</label>
<input type="button" name="signature">
-->

<p><i><font color="blue">Use the browser's back button after previewing to edit and/or send certificate.</font></i></p>
<br>
<input type="submit" name="preview" id="preview" value="Preview Certificate" />
<br><br>
<input type="submit" name="send" id="send" value="Send Certificate" />
<div id="message"></div>
</fieldset>
</form>

</div><!-- /end #award-create-form -->
<script>
$("#award-create").validate({
	rules: {
            'award-type': {
                maxlength: 25
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
			document.getElementById('message').innerHTML = "<span style='color:#00cc00'>Message Sent!</span>";
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
