<div class="form-group required">
    <form method="post" action="<?php echo $action; ?>"> 
        <fieldset>
				<legend><?php echo $legend; ?></legend>
				 <label class="control-label">User email (will be username): <input type="email" name="user_email" required /></label>
		<label class="control-label">Password: <input type="password" name="password" required /></label>
		<label class="control-label">First name: <input type="text" name="first_name" required /></label>
		<label>Middle name (optional): <input type="text" name="middle_name" /></label>
		<label class="control-label">Last name: <input type="text" name="last_name" required /></label>
		<label class="control-label">Job Title: <input type="text" name="job_title" required /></label>
		<label class="control-label">Signature: <input type="file" name="signature" accept="image/*"></label>
		<br><br>
		<input type="submit" value="Submit">
		<p style="color:red;"> <b>(*) denotes required fields.</b></p>
        </fieldset>
	 </form>
</div>