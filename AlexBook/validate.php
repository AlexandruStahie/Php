<?php

	if(!(isset($_SESSION['login']) && $_SESSION['login'] == "OK")) {
		header('Location: login.php');
		exit;
	}
?>