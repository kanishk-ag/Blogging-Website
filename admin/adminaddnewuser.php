<?php
ob_start();
session_start();
if(isset($_SESSION["admin"]))
{
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/styleadminaddnewuser.css">
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
			Blogger	Admin	
		</div>
	</div>
	<div id="user-welcome">
		<p><?php echo "Welcome Admin";?></p>
	</div>
	<div id="menu-list">
			<ul>
				<li><a href="adminviewusers.php" style="text-decoration: none;">View Users</a></li>
				<li><a href="adminviewblogs.php?page=1" style="text-decoration: none;">View Blogs</a></li>
				<li><a href="adminaddnewuser.php" style="text-decoration: none;" class="active">Add New User</a></li>
				<li><a href="adminwriteblog.php" style="text-decoration: none;">Add New Blog</a></li>
				<li><a href="logout.php" style="text-decoration: none;">Logout</a></li>
			</ul>
	</div>
	<div id="heading">
		<p>New User Registration</p>
	</div>
	<div id="new-user-box">
			<form name="form5" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
				<div id="name">
					Name <input type="text" name="name"  placeholder="Enter name" id="new-user-name"><div id="alert-name">Enter valid name</div>
				</div>
				<div id="age">
					Age <input type="number" name="age" placeholder="Enter age" id="new-user-age" min="5" max="100"><div id="alert-age">Enter valid age</div>
				</div>
				<div id="email">
					Email <input type="email" name="email" placeholder="Enter email id" id="new-user-email"><div id="alert-email">Enter valid email</div>
				</div>
				<div id="gender">
					Gender <input type="radio" name="gender" value="Male" id="new-user-gendermale" >Male
					<input type="radio" name="gender" value="Female" id="new-user-genderfemale" >Female
				</div>
				<div id="username">
					Enter Username <input type="text" name="username" id="new-user-username" placeholder="Enter username" >
				</div>
				<div id="password">
					Enter Password <input type="password" name="password" placeholder="Enter password" id="new-user-password">
				</div>
				<div id="confirm-password">
					Confirm Password <input type="password" name="password" placeholder="Re-enter password" id="confirm-new-user-password"><div id="alert-password">Passwords dont match</div>
				</div>
				<div id="userimage">
					Upload Image <input type="file" name="file1" id="new-user-image">
				</div>
				<div id="new-user-buttondiv">
					<input type="submit" name="submit" id="new-user-button" value="Create account" >
				</div>
			</form>
		</div>
		<div id="image">
		
		</div>
		<div id="footer">
		<div id="footer-text">
			Copyright@Kanishk agarwal
		</div>
	</div>
</body>
</html>
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
	$username=$_POST["username"];
	$password=$_POST["password"];
	if(empty($name) or empty($age) or empty($email) or empty($gender) or empty($username) or empty($password))
	{
		echo "<script>alert('All fields should be entered');</script>";
	}
	else
	{
	$con=mysqli_connect("localhost","kanishk11","kanishk11") or die("Couldnt connect");
	mysqli_select_db($con,"blog");
	$checkusername="select Username from users where Username='".$username."'";
	$checkemail="select Email from users where Email='".$email."'";
	$result1=mysqli_query($con,$checkusername);
	$result2=mysqli_query($con,$checkemail);
	if(mysqli_num_rows($result2)>0)
	{
		echo "<script>alert('Given Email is already registered. Try another ID.');</script>";
	}
	else
	{
	if(mysqli_num_rows($result1)>0)
	{
		echo "<script>alert('Username already exists. Try another one.');</script>";
	}
	else
	{
	$filename=$_FILES['file1']['name'];
	$target_dir="../Images/Profile Images/";
	$target_file=$target_dir.basename($_FILES["file1"]["name"]);
	$imagefiletype=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$validextensions=array("jpeg","jpg","gif","png");
	$query="insert into users(Name,Age,Gender,Email,Username,Password) values('".$name."','".$age."','".$gender."','".$email."','".$username."','".$password."')";
	$result=mysqli_query($con,$query);
	if(in_array($imagefiletype,$validextensions))
	{
	$query2="update users set Photo='".$filename."' where Username='".$username."'";
	$result2=mysqli_query($con,$query2);
	move_uploaded_file($_FILES["file1"]["tmp_name"], $target_dir.$filename);
	}
	if(!$result)
	{
		echo "Values can't be inserted".mysqli_error($con);
	}
	else
	{
		header("Location: adminviewusers.php");
	}
	mysqli_close($con);
	}
	}
	}
}
}
else
{
	header("Location: adminlogin.php");
	exit();
}
?>