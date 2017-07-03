<?php

	session_start();
	require_once 'dbpdo.php';
	include 'db.php';	
	include "validate.php";
	include "src/header.php";
	include "src/mainmenu.php";

?>


<html>
<body>
<div id="container"> 
	<fieldset>
	<legend>Newsfeed</legend>

<?php
	if(isset($_POST['Like']))
	{
		$post_id=intval($_POST['postid']);
		$currentuser = $_SESSION['userid'];
		mysql_query("insert into liketable(postid,userid,status) values($post_id,$currentuser,'Like');", $link);
		header('Location: Newsfeed.php');
		exit;
	}

	if(isset($_POST['Unlike']))
	{
		$post_id=intval($_POST['postid']);
		$currentuser = $_SESSION['userid'];
		mysql_query("delete from liketable where postid=$post_id and  userid=$currentuser;", $link);
		header('Location: Newsfeed.php');
		exit;
	}

	if(isset($_POST['commentsub']))
	{
		$post_id=intval($_POST['postid']);
		$user_id=intval($_SESSION['userid']);
		$txt=$_POST['comment_txt'];
		if($txt!="")
		{
		mysql_query("insert into comment(text ,postid, userid) values('$txt', '$post_id','$user_id');", $link);
		}
		header('Location: Newsfeed.php');
		exit;
	}
?>




	<?php
	
		$stmt = $DB_con->prepare('SELECT u.userid, p.postid, p.image, p.title, p.description, p.postdate, u.user 
								FROM post p 
								inner join users u on u.userid = p.userid 
								ORDER BY postdate DESC');
		$stmt->execute();	
		if($stmt->rowCount() > 0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				extract($row);
	?>
				<div style="margin-left: 20px;">
					<div style="margin-left: 100px">
					<?php echo "User: " . $user; ?><br>		
					<?php echo "Titlu: " . $title; ?><br>			 
					<?php echo "Descriere : " .$description; ?><br>
					<?php echo "Date postarii : " .$postdate; ?><br>
					</div>
				<br>

					<img style="margin-left: 100px;" src="user_images/<?php echo $row['image']; ?>" class="img-rounded" width="420px" height="420px" />
				<br>


			<?php
				$currentuser = $_SESSION['userid'];
				$que_like=mysql_query("select * from liketable where postid=$postid", $link);
				$count_like=mysql_num_rows($que_like);

			 	$que_status=mysql_query("select * from liketable where postid=$postid and userid=$currentuser and status = 'Like';", $link);
				$verifyiflike = mysql_num_rows($que_status);

				if($verifyiflike != 0)
				{
			?>
					<span style="padding-top:15;">
						<form style = "display: inline; width: 100px; margin-left: 95px;" method="post">
							<input type="hidden" name="postid" value="<?php echo $postid; ?>">
							<input type="submit" value="Unlike" name="Unlike" style="border:#FFFFFF; background:#FFFFFF; font-size:15px; color:#6D84C4;" >
						</form>
					</span>
			<?php
				}

				else
				{
			?>
					<span style="padding-top:15; ">
						<form method="post" style ="display: inline; width: 95px; margin-left: 95px;">
							<input type="hidden" name="postid" value="<?php echo $postid; ?>">
							<input type="submit" value="Like" name="Like" style="border:#FFFFFF; background:#FFFFFF; font-size:15px; color:#6D84C4;">
						</form>
					</span>
			<?php
				}
		 	?>

			 <?php
		 
			 	$que_comment=mysql_query("select * from comment where postid =$postid order by commentid", $link);
				$count_comment=mysql_num_rows($que_comment);
			 ?>

					<input  type="button" value="Comments(<?php echo $count_comment; ?>)" style="background:#FFFFFF; border:#FFFFFF;font-size:15px; color:#6D84C4;"  id="comment<?php echo $postid; ?>">
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

				<span style="margin-left: 100px;"></span>
				<?php echo $user_name1; ?> <span> : </span> <?php echo $cline1; ?><br>


			<?php
					}	
				}
			?>


			<form method="post", style="margin-left: 100px;">
				<input type="text" name="comment_txt" placeholder="Write a comment..." maxlength="420" style="width:420px;">
				<input type="hidden" name="postid" value="<?php echo $postid; ?>"> 
				<input type="submit", name="commentsub" style="display: none;">
			</form> 

			
			<br><br><br><br>
				
			</div>       
	<?php
			}
		}
		else
		{
	?>
		<span class="glyphicon glyphicon-info-sign"></span> &nbsp; There are no photos in newsfeeed...

	<?php
		}
	?>

</fieldset>
</div>



</body>
</html>