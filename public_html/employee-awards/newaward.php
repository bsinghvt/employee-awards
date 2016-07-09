<?php
require_once(__DIR__.'/website-files/initialize.php');
ob_start(); //from stack overflow
include 'pass.php';
error_reporting(E_ALL);
ini_set('display_errors','On');
session_start();
if (!isset($_SESSION["user_email"]))
{
    header("Location: login.php", true);
}
get_template("header.php");
get_template("nav2.php");
?>


<div id="award-create-form">    

<form id="award-create" method="post" action="get_form_data.php">
<fieldset>    
<label>Input the following information about the person (probably you) giving the award below:</label>
<br>
<label for="a-first-name">First Name</label>
<input type="text" name="a-first-name">
<br>
<label for="a-middle-name">Middle Name</label>
<input type="text" name="a-middle-name">
<br>
<label for="a-last-name">Last Name</label>
<input type="text" name="a-last-name">
<br>
<label for="a-email">Awarder's E-mail</label>
<input type="email" name="a-email">
<br>
<label for="job-title">Awarder's Job Title</label>
<input type="text" name="job-title">
<br>
<label for="award-type">Title of Award</label>
<input type="text" name="award-type">
<br>
<br>
<label for="signature">Signature File</label>
<input type="text" name="signature" value="signature.png">
<br>
<label for="date">Date that Award is Given</label>
<input type="date" name="date">
<br><br>

<label>Input the following information about the award recipient below:</label>
<br>
<label for="r-first-name">First Name</label>
<input type="text" name="r-first-name">
<br>
<label for="r-middle-name">Middle Name</label>
<input type="text" name="r-middle-name">
<br>
<label for="r-last-name">Last Name</label>
<input type="text" name="r-last-name">
<br>
<label for="r-email">Award Recipient's E-mail</label>
<input type="email" name="r-email">
<br>
<input type="radio" name="public" value="public" checked> Public<br>
<input type="radio" name="public" value="private" checked> Private<br>
<label>Public Awards can be viewed by anyone while private awards can only be viewed by recepeint</label>

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
