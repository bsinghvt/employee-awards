<div class="form-group required">
    <form id="userform" enctype="multipart/form-data" method="post" action="<?php echo $action; ?>"> 
        <fieldset>
				<legend><?php echo $legend; ?></legend>
		<label class="control-label" for="useremail">User email (will be username): </label>
		<input id="useremail" class="form-control" type="email" name="user_email" maxlength="30" value="<?php if(isset($user_email))echo htmlentities($user_email); else echo "";?>" required />
		<label class="control-label" for="userpwd">Password: </label>
		<input id="userpwd" class="form-control" type="password" name="password" maxlength="30"  />
		<label class="control-label" for="userfirstname">First name: </label>
		<input id="userfirstname" class="form-control" type="text" name="first_name" maxlength="30" value="<?php if(isset($first_name))echo htmlentities($first_name); else echo "";?>" required />
		<label for="usermiddlename">Middle name (optional): </label>
		<input id="usermiddlename" class="form-control" type="text" name="middle_name" maxlength="30" value="<?php if(isset($middle_name))echo htmlentities($middle_name); else echo "";?>" />
		<label class="control-label" for="userlastname">Last name: </label>
		<input id="userlastname" class="form-control" type="text" name="last_name" maxlength="30" value="<?php if(isset($last_name))echo htmlentities($last_name); else echo "";?>" required />
		<label class="control-label" for="userjobtitle">Job Title: </label>
		<input id="userjobtitle" class="form-control" type="text" name="job_title" maxlength="30" value="<?php if(isset($job_title))echo htmlentities($job_title); else echo "";?>" required />
		<label for="sign"><input id="sign" class="form-control" type="hidden" name="sign" value="<?php if(isset($signature))echo htmlentities($signature); else echo "";?>" /> </label>
		<label for="usersign"><input id="usersign" type="hidden" value="none" /> </label>
		<label for="uid"><input id="uid" class="form-control" type="hidden" name="uid" value="<?php if(isset($uid))echo htmlentities($uid); else echo "";?>" />
		<label for="updatesign">Signature (Max : 1MB) If not uploaded old signature will be used </label>
		<input id="updatesign" class="form-control" type="file" name="signature" accept="image/*">
		<br>
		<input class="btn btn-default" type="submit" value="Submit">
		<p style="color:red;"> <b>(*) denotes required fields.</b></p>
        </fieldset>
	 </form>
</div>