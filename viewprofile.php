<?php
session_start();
if(isset($_SESSION["user"]))
{
$con=mysqli_connect("localhost","kanishk11","kanishk11");
mysqli_select_db($con,'blog');
$query="select * from users where username='".$_SESSION["user"]."'";
$result1=mysqli_query($con,$query);
$row=mysqli_fetch_assoc($result1);
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/viewprofile.css">
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
		<p>Profile Info</p>
	</div>
	<div id="profile">
		<div id="profile-info">
			<b>Name: </b><?php echo $row["Name"];?><br><br>
			<b>Age: </b><?php echo $row["Age"];?><br><br>
			<b>Gender: </b><?php echo $row["Gender"];?><br><br>
			<b>Email: </b><?php echo $row["Email"];?><br><br>
			<b>Username: </b><?php echo $row["Username"];?><br><br>
			<a href="editprofile.php" id="editprofile">Edit Details</a>
		</div>
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
	<div id="footer">
		<div id="footer-text">
			Copyright@Kanishk agarwal
		</div>
	</div>
</body>
</html>
<?php
mysqli_close($con);
}
else
{
	header("Location: index.php");
	exit();
}
?>