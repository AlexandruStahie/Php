<?php
	session_start();
	
	include "src/header.php";
	include "src/mainmenu.php";
?>
<fieldset>
	<legend>Register</legend>

	<form method="post" action="register_action.php">
	
		<p>
			<label for="user">User:</label> 
			<input type="text" name="user" id="user" /> 
		</p>

		<p>
			<label for="password1">Password:</label> 
			<input type="password" name="password1" id="password" />
		</p>

		<p>
			<label for="password2">Confirm password:</label> 
			<input type="password" name="password2" id="password" />
		</p>

		<p class="center"><input value="Register" type="submit" /></p>
	
	</form>
</fieldset>