<div class="form-group required">
    <form method="post" action="<?php echo $action; ?>"> 
        <fieldset>
				<legend><?php echo $legend; ?></legend>
				 <label class="control-label" for="adminemail">User email (will be username): </label><input id="adminemail" class="form-control" type="email" name="user_email" required />
		<label class="control-label" for="adminpwd">Password: </label><input id="adminpwd" class="form-control" type="password" name="password" required />
		<br><br>
		<input class="btn btn-default" type="submit" value="Submit">
		<p style="color:red;"> <b>(*) denotes required fields.</b></p>
        </fieldset>
	 </form>
</div>