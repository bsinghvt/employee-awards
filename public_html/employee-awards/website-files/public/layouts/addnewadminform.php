<div class="form-group required">
    <form method="post" action="<?php echo $action; ?>"> 
        <fieldset>
				<legend><?php echo $legend; ?></legend>
				 <label class="control-label">User email (will be username): <input type="email" name="user_email" required /></label>
		<label class="control-label">Password: <input type="password" name="password" required /></label>
		<br><br>
		<input type="submit" value="Submit">
		<p style="color:red;"> <b>(*) denotes required fields.</b></p>
        </fieldset>
	 </form>
</div>