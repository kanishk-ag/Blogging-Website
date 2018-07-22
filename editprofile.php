<?php
ob_start();
session_start();
if(isset($_SESSION["user"]))
{
$con1=mysqli_connect("localhost","kanishk11","kanishk11");
mysqli_select_db($con1,"blog");
$query="select * from users where Username='".$_SESSION["user"]."'";
$result=mysqli_query($con1,$query);
$row=mysqli_fetch_assoc($result);
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/styleeditprofile.css">
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
	$("#confirm-new-user-password").keyup(function validatepassword()
	{
		var password=document.getElementById("new-user-password").value;
		var confpassword=document.getElementById("confirm-new-user-password").value;
		if(password!=confpassword)
		{
			$("#alert-password").css("display","inline");
			$("#new-user-button").attr("disabled", "disabled");
		}
		else
		{
			$("#alert-password").css("display","none");
			$("#new-user-button").removeAttr("disabled");
		}
	});
});
</script>
</head>
<body>
	<div id="header">
		<div id="header-text">
			Blogger		
	</div>
		<div id="menu-list">
			<ul>
				<li><a href="userpage.php?page=1">Homepage</a></li>
				<li><a href="myblog.php?page=1">View My Blogs</a></li>
				<li><a href="viewprofile.php" class="active">View profile</a></li>
				<li><a href="writeblog.php">Write a blog</a></li>
				<li><a href="userlogout.php">Logout</a></li>
			</ul>
		</div>
	</div>
	<div id="user-welcome">
		<p><?php echo "Welcome user ".$_SESSION["user"];?></p>
	</div>
	<div id="heading">
		<p>Edit Profile</p>
	</div>
	<div id="new-user-box">
			<form name="form4" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
				<div id="name">
					Name<input type="text" name="name" value="<?php echo $row["Name"];?>" id="new-user-name" ><div id="alert-name">Enter valid name</div>
				</div>
				<div id="age">
					Age<input type="number" name="age" value="<?php echo $row["Age"];?>" id="new-user-age" min="5" max="100"><div id="alert-age">Enter valid age</div>
				</div>
				<div id="email">
					Email<input type="email" name="email" value="<?php echo $row["Email"];?>" id="new-user-email"><div id="alert-email">Enter valid email</div>
				</div>
				<div id="gender">
					Gender<input type="radio" name="gender" value="Male" id="new-user-gendermale" <?php if($row["Gender"]=='Male'){echo "checked";}?>>Male
					<input type="radio" name="gender" value="Female" id="new-user-genderfemale" <?php if($row["Gender"]=='Female'){echo "checked";}?> >Female
				</div>
				<div id="password">
					Change Password<input type="text" name="password" value="<?php echo $row['Password'];?>" id="new-user-password">
				</div>
				<div id="confirm-password">
					Confirm Password <input type="password" name="confpassword" placeholder="Re-enter password" id="confirm-new-user-password"><div id="alert-password">Passwords dont match</div>
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
			$img_src="Images/Profile Images/nopic.jpg";
		}
		else
		{
			$image=$row["Photo"];
			$img_src="Images/Profile Images/".$image;
		}
		?>
		<img src="<?php echo $img_src;?>">
		</div>
<?php
if(isset($_POST["submit"]))
{
	$name=$_POST["name"];
	$age=$_POST["age"];
	$email=$_POST["email"];
	if(isset($_POST["gender"]))
	{
	$gender=$_POST["gender"];
	}
	$username=$_SESSION["user"];
	$password=$_POST["password"];
	$confpassword=$_POST["confpassword"];
	if(empty($name) || empty($age) || empty($email) || empty($gender) || empty($password))
	{
		echo "<script>alert('No field can be empty');</script>";
	}
	else
	{
		if(empty($confpassword)){ echo "<script>alert('Re-enter the password');</script>";}
		else
		{
	$con=mysqli_connect("localhost","kanishk11","kanishk11") or die("Couldnt connect");
	mysqli_select_db($con,"blog");
	$filename=$_FILES['file1']['name'];
	$target_dir="Images/Profile Images/";
	$target_file=$target_dir.basename($_FILES["file1"]["name"]);
	$imagefiletype=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$validextensions=array("jpeg","jpg","gif","png");
	if(in_array($imagefiletype, $validextensions))
	{
		$query5="update users set Photo='".$filename."'where Username='".$username."'";
		$result5=mysqli_query($con,$query5);
	}
	$query1="update users set Name='".$name."' where Username='".$username."'";
	$query2="update users set Age='".$age."' where Username='".$username."'";
	$query3="update users set Email='".$email."' where Username='".$username."'";
	$query4="update users set Gender='".$gender."' where Username='".$username."'";
	$result1=mysqli_query($con,$query1);
	$result2=mysqli_query($con,$query2);
	$result3=mysqli_query($con,$query3);
	$result4=mysqli_query($con,$query4);
	
	if(!$result1 || !$result2 || !$result3 || !$result4)
	{
		echo "Values cant be updated".mysqli_error($con);
	}
	else
	{
		header("Location: viewprofile.php");
	}
	mysqli_close($con);
	}
}
}
}
else
{
	header("Location: index.php");
	exit();
}
?>
	<div id="footer">
		<div id="footer-text">
			Copyright@Kanishk agarwal
		</div>
	</div>
</body>
</html>
