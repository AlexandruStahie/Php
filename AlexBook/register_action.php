<?php 
	include 'db.php';
	
	$user = $_POST['user'];
	$password1 =  $_POST['password1'];
	$password2 =  $_POST['password2'];
	
	if ($password1 != $password2) {
		include "src/header.php";
		include "src/mainmenu.php";
		echo '<p>Error: password does not match. Try again</a>';
		echo '<p><a href="register.php">Try again</p>';
		exit;
	}
	
	$sql = "INSERT INTO users (user, password) VALUES ('$user', '$password1');";
	$result = mysql_query($sql, $link);
	
	if ($result == false) {
		include "src/header.php";
		include "src/mainmenu.php";
		echo '<p>Error: cannot execute query</p>';
		echo '<p><a hrdef="register.php">Try again</a></p>';
		exit;
	}
	else {
		header('Location: private.php');
	}

	mysql_close($link);
?>