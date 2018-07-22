<?php
session_start();
if(isset($_SESSION["admin"]))
{
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/styleadminwriteblog.css">
</head>
<body>
	<div id="header">
		<div id="header-text">
			Blogger	Admin	
		</div>
	</div>
	<div id="user-welcome">
		<p>Welcome Admin</p>
	</div>
	<div id="menu-list">
			<ul>
				<li><a href="adminviewusers.php" style="text-decoration: none;">View Users</a></li>
				<li><a href="adminviewblogs.php?page=1" style="text-decoration: none;">View Blogs</a></li>
				<li><a href="adminaddnewuser.php" style="text-decoration: none;">Add New User</a></li>
				<li><a href="adminwriteblog.php" style="text-decoration: none;" class="active">Add New Blog</a></li>
				<li><a href="logout.php" style="text-decoration: none;">Logout</a></li>
			</ul>
	</div>
	<div id="heading">
		<p>Admin Blog</p>
	</div>
	<div id="new-blog-box">
		<div id="form" style="width: 100%;float: left;">
			<form name="form3" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
				<div id="title">
					Enter title for blog <input type="text" name="title" placeholder="Enter title" id="blog-title">
				</div>
				<div id="messagediv">
					Enter Blog message <br><textarea name="blog" id="message" cols="45" rows="5" placeholder="Write blog"></textarea>
				</div>
					<input type="submit" name="submit" id="blog-button" value="Submit Blog">
			</form>
		</div>
	</div>
<?php
if($_SERVER['REQUEST_METHOD']=="POST")
{
if(isset($_POST["submit"]))
{
	$title=$_POST["title"];
	$message=$_POST["blog"];
	$user=$_SESSION["admin"];
	if(empty($title))
	{
		echo "<script>alert('Please enter a title');</script>"; 
	}
	else if(empty($message))
	{
		echo "<script>alert('Please enter the Blog');</script>"; 
	}
	else
	{
$con=mysqli_connect("localhost","kanishk11","kanishk11");
mysqli_select_db($con,'blog');
$date=date("Y-m-d");
$query="insert into blogs(Username,Title,Blog,Date) values('".$user."','".$title."','".$message."','".$date."')";
$insert=mysqli_query($con,$query);
	if(!$insert)
	{
	echo "Blog not saved ".mysqli_error($con);
	}
	else
	{
	header("Location: adminviewblogs.php?page=1");
	}
	mysqli_close($con);
	}
	}
}
?>
	<div id="footer">
		<div id="footer-text">
			Copyright@Kanishk agarwal
		</div>
	</div>
</body>
</html>
<?php
}
else
{
	header("Location: adminlogin.php");
	exit();
}