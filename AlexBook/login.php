<?php


	session_start();

	include "src/header.php";
	include "src/mainmenu.php";
?>

	
<fieldset>
<legend>Login</legend>

	<form method="post" action="login_action.php">
	<p>
		<label for="user">User:</label> 
		<input type="text" name="user" id="user" />
	</p>

	<p>
		<label for="password">Password:</label> 
		<input type="password" name="password" id="password" />
	</p>
	
	<p class="center"><input value="Login" type="submit" class="center" /></p>
	</form>

</fieldset>