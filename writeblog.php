<?php
session_start();
if(isset($_SESSION["user"]))
{
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/stylewriteblog.css">
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
				<li><a href="viewprofile.php">View profile</a></li>
				<li><a href="writeblog.php" class="active">Write a blog</a></li>
				<li><a href="userlogout.php">Logout</a></li>
			</ul>
		</div>
	</div>
	<div id="user-welcome">
		<p><?php echo "Welcome user ".$_SESSION["user"];?></p>
	</div>
	<div id="heading">
		<p>Write a Blog</p>
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
		<div id="image">
		<img src="images/login-background.jpg">
		<div id="alert">
<?php
if($_SERVER['REQUEST_METHOD']=="POST")
{
if(isset($_POST["submit"]))
{
	$title=$_POST["title"];
	$message=$_POST["blog"];
	$user=$_SESSION["user"];
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
	header("Location: userpage.php?page=1");
	}
	mysqli_close($con);
	}
	}
}
?>
</div></div>
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
	header("Location: index.php");
	exit();
}