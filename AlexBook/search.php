<?php

	session_start();
	
	include "src/header.php";
	include "src/mainmenu.php";
?>
	<form method="post" action="search_result.php">
	<fieldset>
	<legend>Search</legend>
	<p><label for="user">User:</label> <input type="text" name="user" id="user" /></p>
	<p class="center"><input type="submit" value="Search" /></p>
	</fieldset>
	</form>
