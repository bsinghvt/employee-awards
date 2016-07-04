<div class="form-group required">
    <form enctype="multipart/form-data" method="post" action="<?php echo $action; ?>"> 
        <fieldset>
				<legend><?php echo $legend; ?></legend>
		<label class="control-label" for="useremail">User email (will be username): </label><input id="useremail" class="form-control" type="email" name="user_email" required />
		<label class="control-label" for="userpwd">Password: </label><input id="userpwd" class="form-control" type="password" name="password" required />
		<label class="control-label" for="userfirstname">First name: </label><input id="userfirstname" class="form-control" type="text" name="first_name" required />
		<label for="usermiddlename">Middle name (optional): </label><input id="usermiddlename" class="form-control" type="text" name="middle_name" />
		<label class="control-label" for="userlastname">Last name: </label><input id="userlastname" class="form-control" type="text" name="last_name" required />
		<label class="control-label" for="userjobtitle">Job Title: </label><input id="userjobtitle" class="form-control" type="text" name="job_title" required />
		<label for="maxsize"><input id="maxsize" class="form-control" type="hidden" name="MAX_FILE_SIZE" value="204800" />
		<label class="control-label" for="usersign">Signature (Max : 200KB): </label><input id="usersign" class="form-control" type="file" name="signature" accept="image/*">
		<br>
		<input class="btn btn-default" type="submit" value="Submit">
		<p style="color:red;"> <b>(*) denotes required fields.</b></p>
        </fieldset>
	 </form>
</div>