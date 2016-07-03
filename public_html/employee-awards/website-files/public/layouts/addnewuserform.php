<div class="form-group">
    <form method="post" action="<?php echo $action; ?>"> 
        <fieldset>
				<legend><?php echo $legend; ?></legend>
				<p>User email (will be username): <input type="email" name="user_email" required /></p>
		<p>Password: <input type="password" name="password" required /></p>
		<p>First name: <input type="text" name="first_name" required /></p>
		<p>Middle name (optional): <input type="text" name="middle_name" /></p>
		<p>Last name: <input type="text" name="last_name" required /></p>
		<p>Job Title: <input type="text" name="job_title" required /></p>
		<p>Signature:  <input type="file" name="signature" accept="image/*">
		<br><br>
		<input type="submit" value="Submit">
        </fieldset>
	 </form>
</div>