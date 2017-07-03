<?php

	session_start();

	if(!isset($_GET['userid']) || empty($_GET['userid'])) {
		header('Location: search.php');
	}
	
	// Check if the user is logged into the system
	include "validate.php";
	include "src/header.php";
	include "src/mainmenu.php";

	include 'db.php';
	
	
	echo "<fieldset><legend>User Information</legend>";

	$userid = $_GET['userid'];	
	$sql = "select * from users where userid = $userid;";
	$result = mysql_query($sql, $link);
	
	if ($result == false) {
		echo "<p>Error: cannot execute query</p>";
	}
	else {
		$num_rows = mysql_num_rows($result);

		if ($num_rows >= 1) {
			while($row = mysql_fetch_array($result)) {
				echo "<h2>";
				echo "<b>User:</b> " . $row["user"] . "<br />";
				echo "</h2>";
			}
		}
		else {
			echo "<p>No user</p>";
		}
	}

	
	mysql_close($link);

?>


<?php
	
	include 'dbpdo.php';
	include 'db.php';

	$userid = $_GET['userid'];	
	$stmt = $DB_con->prepare('SELECT u.userid, p.postid, p.image, p.title, p.description, p.postdate, u.user, count(l.liekid) 
									FROM post p 
									inner join users u on u.userid = p.userid 
									left join liketable l on l.postid = p.postid 
									where u.userid = :userid
									group by p.postid 
									order by COUNT(l.liekid) desc , p.postdate desc');
		$stmt->bindParam(':userid',$userid);
		$stmt->execute();
		
		if($stmt->rowCount() > 0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
					extract($row);
	?>
					<div style="margin-left: 100px">
					<?php echo "Titlu: " . $title; ?><br>			 
					<?php echo "Descriere : " .$description; ?><br>
					<?php echo "Date postarii : " .$postdate; ?>

					</div>
				<br>

					<img style="margin-left: 100px;" src="user_images/<?php echo $row['image']; ?>" class="img-rounded" width="420px" height="420px" />
				<br>

			<?php
		 			//COMMENT
			 		$que_comment=mysql_query("select * from comment where postid =$postid order by commentid", $link);
					$count_comment=mysql_num_rows($que_comment);

					//LIKE
					$que_status=mysql_query("select * from liketable where postid=$postid and userid=$userid;", $link);
					$que_like=mysql_query("select * from liketable where postid=$postid");
					$count_like=mysql_num_rows($que_like);
					$status_data=mysql_fetch_array($que_status);
		 	?>

						<input  type="button" value="Comments(<?php echo $count_comment; ?>)" style=" margin-left: 95px; background:#FFFFFF; border:#FFFFFF;font-size:15px; color:#6D84C4;"  id="comment<?php echo $postid; ?>">
					<br>
						<img src="img/like.PNG", style="margin-left: 100px;">
						<span bgcolor="#EDEFF4" style= "width: 50px;"><?php echo $count_like; ?>
						</span> like this. 
					<br><br>
			<?php

				while($comment_data=mysql_fetch_array($que_comment))
				{
					$comment_id=$comment_data[0];
					$comment_user_id=$comment_data[3];
					$que_user_info1=mysql_query("select * from users where userid=$comment_user_id");
					$fetch_user_info1=mysql_fetch_array($que_user_info1);
					$user_name1=$fetch_user_info1[1];

					$clen=strlen($comment_data[1]);
					if($clen>0 && $clen<=60)
					{
						$cline1=substr($comment_data[1],0,60);
			?>

				<div style="margin-left:100px;">
				<?php echo $user_name1; ?> <span> : </span> <?php echo $cline1; ?><br>
				</div>
			<?php
					}	
				}
			?>

			<br><br><br>
				
			     
<?php
		}
	}
	else
	{
?>
	<span class="glyphicon glyphicon-info-sign"></span> &nbsp; No Photos Found ...

<?php
	}
?>
</div>
