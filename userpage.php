<?php
session_start();
if(isset($_SESSION["user"]))
{
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/styleuserpage.css">
</head>
<body>
	<div id="header">
		<div id="header-text">
			Blogger		
	</div>
		<div id="menu-list">
			<ul><li><a href="userpage.php?page=1" class="active">Homepage</a></li>
				<li><a href="myblog.php?page=1">View My Blogs</a></li>
				<li><a href="viewprofile.php">View profile</a></li>
				<li><a href="writeblog.php">Write a blog</a></li>
				<li><a href="userlogout.php">Logout</a></li>
			</ul>
		</div>
	</div>
	<div id="user-welcome">
		<p><?php echo "Welcome user ".$_SESSION["user"];?></p>
	</div>
	<div id="heading">
		<p>User Blogs</p>
	</div>
<?php
	$con2=mysqli_connect("localhost","kanishk11","kanishk11");
	mysqli_select_db($con2,"blog");
	$page=$_GET["page"];
	if($page=="1")
	{
		$pageid=0;
	}
	else
	{
		$pageid=($page*2)-2;
	}
	$select="select * from blogs order by ID desc LIMIT ".$pageid.",2";
	$query=mysqli_query($con2,$select);
	while($row=mysqli_fetch_assoc($query))
	{
	?>

	<div id="blogs">
		<div id="userimage">
		<?php
		$username=$row["Username"];
		$select2="select Photo from users where Username='".$username."'";
		$query2=mysqli_query($con2,$select2);
		$row2=mysqli_fetch_assoc($query2);
		if($username=="admin")
		{
		$img_src="Images/Profile Images/admin-photo.png";
		}
		else if(empty($row2["Photo"]))
		{
			$img_src="Images/Profile Images/nopic.jpg";
		}
		else
		{
			
			$image=$row2["Photo"];
			$img_src="Images/Profile Images/".$image;
		}
		?>
		<img src="<?php echo $img_src;?>">
		</div>
		<div id="blogdiv">
			<div id="blog-title">
				<?php echo $row["Title"];?>
				<div id="blog-by-line">
				By: <?php echo $row["Username"]."<font size='3px'> (on ".$row["Date"]; echo ")</font></div></div>";?>
			<div id="blog-message">
				<?php echo $row["Blog"]; echo "</div></div></div>";} ?>
	<div id="paging">
<?php
$recperpage=2;
$select2="select * from blogs";
$query2=mysqli_query($con2,$select2);
$count=mysqli_num_rows($query2);
$page=ceil($count/2);
for($pageno=1;$pageno<=$page;$pageno++)
{
?><a href="userpage.php?page=<?php echo $pageno;?>"><?php echo $pageno;?></a>
<?php
}
 mysqli_close($con2);?>
 </div>
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