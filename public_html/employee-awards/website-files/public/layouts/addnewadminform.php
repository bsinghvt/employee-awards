<div class="form-group required">
    <form method="post" action="<?php echo $action; ?>"> 
        <fieldset>
				<legend><?php echo $legend; ?></legend>
				 <label class="control-label" for="adminemail">User email (will be username): </label>
				 <input id="adminemail" class="form-control" type="email" name="user_email" maxlength="30" value="<?php if(isset($user_email))echo htmlentities($user_email); else echo "";?>" required />
		<label class="control-label" for="adminpwd">Password: </label>
		<input id="adminpwd" class="form-control" type="password" name="password" maxlength="30" required />
		<label for="id"><input id="id" class="form-control" type="hidden" name="id" value="<?php if(isset($admin_id))echo htmlentities($admin_id); else echo "";?>" />
		<br>
		<input class="btn btn-default" type="submit" value="Submit">
		<p style="color:red;"> <b>(*) denotes required fields.</b></p>
        </fieldset>
	 </form>
</div>