<?php
	session_start();
	require_once 'dbpdo.php';
	include "src/header.php";
	include "src/mainmenu.php";
	
	if(isset($_POST['btnsave']))
	{
		$title = $_POST['title'];// user name
		$description = $_POST['description'];// description

		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
			
		if(empty($title)){
			$errMSG = "Please Enter Title:";
		}
		else if(empty($description)){
			$errMSG = "Please Enter Your Description";
		}
		else if(empty($imgFile)){
			$errMSG = "Please Select Image File.";
		}
		else
		{
			$upload_dir = 'user_images/'; // upload directory
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
		
			// rename uploading image
			$image = rand(1000,1000000).".".$imgExt;
				
			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){			
				// Check file size '5MB'
				if($imgSize < 5000000)				{
					move_uploaded_file($tmp_dir,$upload_dir.$image);
				}
				else{
					$errMSG = "Sorry, your file is too large.";
				}
			}
			else{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
			}
		}
				
		// if no error occured, continue ....
		if(!isset($errMSG))
		{

			$stmt = $DB_con->prepare('INSERT INTO post(image, title, description, userid) VALUES(:image, :title, :description, :userid)');
			$stmt->bindParam(':image',$image);
			$stmt->bindParam(':title',$title);
			$stmt->bindParam(':description',$description);
			$stmt->bindParam(':userid',$_SESSION['userid']);
		
			if($stmt->execute())
			{
				$successMSG = "new record succesfully inserted ...";
				header("refresh:5;private.php"); // redirects image view page after 5 seconds.
			}
			else
			{
				$errMSG = "error while inserting....";
			}
		}
	}
?>

<html>
<body>
<div id="container">
<fieldset>
	<legend>Add new Image</legend>
	

	<div class="page-header">
    	<h3 class="h2">Add a new picture:  <a class="btn btn-default" href="private.php"> <span class="glyphicon glyphicon-eye-open"> <br> </span> Back to all my pictures </a></h3>
    </div>
    

	<?php
	if(isset($errMSG))
	{
	?>
    	<div class="alert alert-danger">
    	<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
        </div>
    <?php
	}
	else if(isset($successMSG))
	{ 
	?>
        <div class="alert alert-success">
     	<strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div>
    <?php
	}
	?>   

	<form method="post" enctype="multipart/form-data">	
	    <p>
	    	<label>Title</label>
	        <input id = "user" type="text" name="title" placeholder="Enter title" />
	 	</p>
	    
	    <p>
	    	<label>Description</label>
	        <input id = "user" type="text" name="description" placeholder="Your description"/>
	 	</p>
		
	    	<label>Image</label>
	        <input style= "width: 250px;" class="image" type="file" name="user_image" accept="image/*" />       

	    <p>
	        <button type="submit" name="btnsave" class="btn btn-default">
	        <span class="glyphicon glyphicon-save"></span> &nbsp; Save &nbsp;
	        </button>
	  	</p>      
	</form>
    
</div>
</fieldset>
</body>
</html>