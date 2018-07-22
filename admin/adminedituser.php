<?php
session_start();
if(isset($_SESSION["admin"]))
{
$id=$_GET["id"];
$con=mysqli_connect('localhost','kanishk11','kanishk11') or die("Couldnt connect");
mysqli_select_db($con,"blog");
$query="select * from users where ID='".$id."'";
$exec=mysqli_query($con,$query);
$row=mysqli_fetch_assoc($exec);
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/adminpanel.css">
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
<script>
	$("document").ready(function(){
	$("#new-user-name").keyup(function validatename()
	{	var namere=/\d/;
		var name=document.getElementById("new-user-name").value;
		if(namere.test(name))
		{
			$("#alert-name").css("display","inline");
			$("#new-user-button").attr("disabled","disabled");
		}
		else
		{
			$("#alert-name").css("display","none");
			$("#new-user-button").removeAttr("disabled");
		}
	});
	 $("#new-user-age").keyup(function validateage()
	 {	var agere=/\D/;
	 	var age=document.getElementById("new-user-age").value;
	 	if(age<5 || age>100 || agere.test(age))
	 	{
	 		$("#alert-age").css("display","inline");
	 		$("#new-user-button").attr("disabled","disabled");
	 	}
	 	else
	 	{
	 		$("#alert-age").css("display","none");
	 		$("#new-user-button").removeAttr("disabled");
	 	}
	 });
	$("#new-user-email").keyup(function validateemail()
	{	var emailre=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/i;
		var email=document.getElementById("new-user-email").value;
		if(!emailre.test(email))
		{
			$("#alert-email").css("display","inline");
			$("#new-user-button").attr("disabled","disabled");
		}
		else
		{
			$("#alert-email").css("display","none");
			$("#new-user-button").removeAttr("disabled");
		}
	});
});
</script>
</head>
<body>
	<div id="header">
		<div id="header-text">
			Blogger	Admin	
		</div>
		
	</div>
	<div id="user-welcome">
		<p><?php echo "Welcome Admin";?></p>
	</div>
	<div id="menu-list">
			<ul>
				<li><a href="adminviewusers.php" style="text-decoration: none;" class="active">View Users</a></li>
				<li><a href="adminviewblogs.php?page=1" style="text-decoration: none;">View Blogs</a></li>
				<li><a href="adminaddnewuser.php" style="text-decoration: none;">Add New User</a></li>
				<li><a href="adminwriteblog.php" style="text-decoration: none;">Add New Blog</a></li>
				<li><a href="logout.php" style="text-decoration: none;">Logout</a></li>
			</ul>
	</div>
	<div id="heading" style="margin-left: 80px;">
		<p>Edit user details</p>
	</div>

<div id="new-user-box" style="margin-left: 100px;">
			<form name="form4" action="adminupdateuser.php" method="post" enctype="multipart/form-data">
				<div id="username">
					Username<input type="text" name="username" value="<?php echo $row['Username'];?>" id="new-user-username" readonly>
				</div>
				<div id="name">
					Name<input type="text" name="name" value="<?php echo $row['Name'];?>" id="new-user-name" ><div id="alert-name">Enter valid name</div>
				</div>
				<div id="age">
					Age<input type="number" name="age" value="<?php echo $row['Age'];?>" id="new-user-age" min="5" max="100"><div id="alert-age">Enter valid age</div>
				</div>
				<div id="email">
					Email<input type="email" name="email" value="<?php echo $row['Email'];?>" id="new-user-email"><div id="alert-email">Enter valid email</div>
				</div>
				<div id="gender">
					Gender<input type="radio" name="gender" value="Male" id="new-user-gendermale" <?php if($row["Gender"]=='Male'){echo "checked";}?>>Male
					<input type="radio" name="gender" value="Female" id="new-user-genderfemale" <?php if($row["Gender"]=='Female'){echo "checked";}?>>Female
				</div>
				<div id="userimage">
					Upload Image <input type="file" name="file1" id="new-user-image">
				</div>
				<div id="new-user-buttondiv">
					<input type="submit" name="submit" id="new-user-button" value="Update">
				</div>
			</form>
		</div>
	<div id="image">
		<?php
		if(empty($row["Photo"]))
		{
			$img_src="../Images/Profile Images/nopic.jpg";
		}
		else
		{
			$image=$row["Photo"];
			$img_src="../Images/Profile Images/".$image;
		}
		?>
		<img src="<?php echo $img_src;?>">
	</div>
<?php
$username=$row["Username"];
if(isset($_POST["submit"]))
{
	$name=$_POST["name"];
	$age=$_POST["age"];
	$email=$_POST["email"];
	$gender=$_POST["gender"];
	$password=$_POST["password"];
	if(empty($name) || empty($age) || empty($email) || empty($gender) || empty($password))
	{
		echo "<script>alert('No field can be empty');</script>";
	}
	else
	{
		$filename=$_FILES['file1']['name'];
	$target_dir="Images/Profile Images/";
	$target_file=$target_dir.basename($_FILES["file1"]["name"]);
	$imagefiletype=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$validextensions=array("jpeg","jpg","gif","png");
	if(in_array($imagefiletype, $validextensions))
	{
		$query="update users set Photo='".$filename."'where Username='".$username."'";
		$result=mysqli_query($con,$query5);
	}
	$query1="update users set Name='".$name."',Age='".$age."',Email='".$email."',Gender='".$gender."',Password='".$password."' where Username='".$username."'";
	$result1=mysqli_query($con,$query1);
	if(!$result1)
	{
		echo "Values cant be updated".mysqli_error($con);
	}
	else
	{
		echo "Information updated!";
		header('Location: adminviewusers.php');
		exit();
	}
	}
	mysqli_close($con);
}
}
else
{
	header("Location: adminlogin.php");
}
?>
<div id="footer">
		<div id="footer-text">
			Copyright@Kanishk agarwal
		</div>
	</div>
</body>
</html>