<?php

	session_start();

	include "src/header.php";
	include "src/mainmenu.php";
	include 'db.php';

	echo "<fieldset><legend>Users</legend>";

	if(!isset($_POST['user']) || empty($_POST['user'])) {
		echo "<p>Empty search is not allowed</p>";
	}
	else {
		$user = $_POST['user'];
	
		$sql = "select userid, user from users where user like '%$user%';";
		$result = mysql_query($sql, $link);
		
		if ($result == false) {
			echo '<p>Error: cannot execute query</p>';
		}
		else {
			$num_rows = mysql_num_rows($result);

			if($num_rows >= 1) {
				while($row = mysql_fetch_array($result)) {
					echo "<p>";
					echo "<b>user:</b> " . "<a href=\"search_full_result.php?userid={$row["userid"]}\">" . $row["user"] . "</a><br />";
					echo "</p>";
				}
			}
			else {
				echo '<p>No user found</p>';
			}
		}
	}
	
	mysql_close($link);
	
	echo "</fieldset>";
	
?>