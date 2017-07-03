<nav>
<ul id="main_menu">
	<li><a href="register.php" title="Register new user">Register</a></li>

	<?php
	  if(isset($_SESSION['login']) && $_SESSION['login'] == "OK") {
		echo '<li><a href="search.php" title="Users list">Search</a></li>';
	  }
	?>

	<li><a href="login.php" title="Login private area">Login</a></li>
	
	<?php
	  if(isset($_SESSION['login']) && $_SESSION['login'] == "OK") {
		echo '<li><a href="newsfeed.php" title="News">Newsfeed</a></li>';
	  }
	?>

	<?php
	  if(isset($_SESSION['login']) && $_SESSION['login'] == "OK") {
		echo '<li><a href="private.php" title="Private area">Home</a></li>';
		echo '<li style="padding-left: 200px"> User: ' . $_SESSION['user'] . ' | <a href="exit.php">Log Out </a></li>';
	  }
	?>

	
</ul>
</nav>
