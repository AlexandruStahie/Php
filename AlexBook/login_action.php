<?php

	session_start();		
	include 'db.php';

	$user = $_POST['user'];
	$password = $_POST['password'];
	$sql = "select userid, user, password from users where user = '$user' and password = '$password'";
	$result = mysql_query($sql, $link);
	
	if ($result == false) {
		echo '<a href="login.php">Error: cannot execute query</a>';
		exit;
	}
	
	$num_rows = mysql_num_rows($result);
	$rows = mysql_fetch_assoc($result);

	if ($num_rows == 1) {
		$_SESSION['login'] = "OK";
		$_SESSION['userid'] = $rows['userid'];
		$_SESSION['user'] = $user;
		header('Location: private.php');
		mysql_close($link);
		die();
	}
	
	mysql_close($link);
	
	header('Location: login.php');
?>