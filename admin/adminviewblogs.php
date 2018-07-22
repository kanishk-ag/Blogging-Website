<?php
session_start();
if(isset($_SESSION["admin"]))
{
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/styleadminviewblogs.css">
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
			<li><a href="adminviewblogs.php?page=1 id="active" style="text-decoration: none;" class="active">View Blogs</a></li>
			<li><a href="adminaddnewuser.php" style="text-decoration: none;">Add New User</a></li>
			<li><a href="adminwriteblog.php" style="text-decoration: none;">Add New Blog</a></li>
			<li><a href="logout.php" style="text-decoration: none;">Logout</a></li>
		</ul>
	</div>	
	<div id="heading">
	<p>User Blogs</p>
	</div>
<?php
	$con2=mysqli_connect("localhost","kanishk11","kanishk11");
	mysqli_select_db($con2,"blog");
	if(isset($_GET["page"]))
	{
	$page=$_GET["page"];
	}
	else
	{
		$page=1;
	}
	if($page==1)
	{
		$pageid=0;
	}
	else
	{	
		$pageid=($page*1)-1;
	}
	$select="select * from blogs order by ID desc LIMIT ".$pageid.",1";
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
		$img_src="../Images/Profile Images/admin-photo.png";
		}
		else if(empty($row2["Photo"]))
		{
			$img_src="../Images/Profile Images/nopic.jpg";
		}
		else
		{
			
			$image=$row2["Photo"];
			$img_src="../Images/Profile Images/".$image;
		}
		?>
		<img src="<?php echo $img_src;?>">
		</div>
		<div id="blogdiv">
			<div id="blog-title">
				<?php echo $row["Title"];?>
				<div id="blog-by-line">
				By:<?php echo $row["Username"]."<font size='3px'> (on ".$row["Date"]; echo ")</font>";?>
				<div style="float: right;width: 10%;text-align: right;">
					<?php echo "<a href='admindeleteblog.php?id=".$row['ID']."'>"?><img src="../images/delete.png" style="width: 25px;height: 25px;"></a>
				</div>
				</div>
		</div>
			<div id="blog-message">
				<?php echo $row["Blog"]; echo "</div></div></div>";} ?>
<?php
$select2="select * from blogs";
$query2=mysqli_query($con2,$select2);
$count=mysqli_num_rows($query2);
$recperpage=ceil($count/1);
?>
<div id="paging">
<?php
for($pageno=1;$pageno<=$recperpage;$pageno++)
{
	?><a href="adminviewblogs.php?page=<?php echo $pageno;?>" id='paging-link'><?php echo $pageno;}?></a>
<?php
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
	header("Location: adminlogin.php");
	exit();
}
?>