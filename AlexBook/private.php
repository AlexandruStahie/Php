<?php

	session_start();
	require_once 'dbpdo.php';
	include 'db.php';
	
	include "validate.php";
	include "src/header.php";
	include "src/mainmenu.php";
	?>
	
<div id="container">
<fieldset>
	<legend>Home</legend>

	<?php
echo '<h1 class = "h2"> Welcome ' . $_SESSION['user'] . '</h1>';

if(isset($_GET['delete_id']))
	{
		// select image from db to delete
		$stmt_select = $DB_con->prepare('SELECT image FROM post WHERE postid =:pid');
		$stmt_select->execute(array(':pid'=>$_GET['delete_id']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("user_images/".$imgRow['image']);
		
		// it will delete an actual record from db
		$stmt_delete = $DB_con->prepare('DELETE FROM post WHERE postid =:pid');
		$stmt_delete->bindParam(':pid',$_GET['delete_id']);
		$stmt_delete->execute();
		
		$stmt_delete2 = $DB_con->prepare('DELETE FROM comment WHERE postid =:pid');
		$stmt_delete2->bindParam(':pid',$_GET['delete_id']);
		$stmt_delete2->execute();

		$stmt_delete3 = $DB_con->prepare('DELETE FROM liketable WHERE postid =:pid');
		$stmt_delete2->bindParam(':pid',$_GET['delete_id']);
		$stmt_delete2->execute();

		header("Location: private.php");
	}
?>
<html>

<body>


	
	<div class="page-header">
    	<h3>Here are all your photos ordered by likes number: <br> 
    	<a class="btn btn-default" href="addnew.php"> 
    	<span class="glyphicon glyphicon-plus">
    	</span>Add a new photo </a></h3> 
    </div>
    
<br />

	<?php	
		$stmt = $DB_con->prepare('SELECT u.userid, p.postid, p.image, p.title, p.description, p.postdate, u.user, count(l.liekid) 
									FROM post p 
									inner join users u on u.userid = p.userid 
									left join liketable l on l.postid = p.postid 
									where u.userid = :userid
									group by p.postid 
									order by COUNT(l.liekid) desc , p.postdate desc');
		$stmt->bindParam(':userid',$_SESSION['userid']);
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
					
					<a class="btn btn-danger" href="?delete_id=<?php echo $row['postid']; ?>" title="click for delete" onclick="return confirm('sure to delete ?')"><span class="glyphicon glyphicon-remove-circle"><br></span> Delete</a>

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



</fieldset>
</body>
</html>