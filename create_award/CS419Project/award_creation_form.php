<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Award Creation HTML5 Form</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

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
<label for="a-job-title">Awarder's Job Title</label>
<input type="text" name="a-job-title">
<br>
<label for="award-type">Title of Award</label>
<input type="text" name="award-type">
<br>
<br>
<label for="signature">Signature File</label>
<input type="text" name="signature" value="signature.png">
<br>
<label for="date">Date that Award is Given</label>
<input type="text" name="date">
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

<!-- Be able to upload photo of signature later after basic form works.
<label for="signature">Upload Your Signature</label>
<input type="button" name="signature">
-->


<input type="submit" name="submit" id="submit" value="Send Certificate" />

</fieldset>
</form>

</div><!-- /end #award-create-form -->

</body>
</html>