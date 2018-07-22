<?php
session_start();
if(isset($_SESSION["user"]))
{
	$pageid=$_GET["page"];
if($pageid==1)
{
	$page=0;
}
else
{
	$page=($pageid*1)-1;
}
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/stylemyblog.css">
</head>
<body>
	<div id="header">
		<div id="header-text">
			Blogger		
	</div>
		<div id="menu-list">
			<ul>
				<li><a href="userpage.php?page=1">Homepage</a></li>
				<li><a href="myblog.php?page=1" class="active">View My Blogs</a></li>
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
		<p>Blogs by you</p>
	</div>
<?php
	$con2=mysqli_connect("localhost","kanishk11","kanishk11");
	mysqli_select_db($con2,"blog");
	$select="select * from blogs where Username='".$_SESSION["user"]."' order by ID desc LIMIT ".$page.",1";
	$query=mysqli_query($con2,$select);
	if(!$query || mysqli_num_rows($query)==0)
	{
?>
<div id='no-blogs'>
	<div style="width: 100%;position: absolute;top:100px;">
	You have no blogs yet.
	</div>
</div>
<?php	
}
	else
	{
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
				By:<?php echo $row["Username"]."<font size='3px'> (on ".$row["Date"]; echo ")</font>";?>
				<div style="float: right;width: 10%;text-align: right;">
					<?php echo "<a href='deleteblog.php?id=".$row['ID']."'>"?><img src="images/delete.png" style="width: 25px;height: 25px;background-color: white;"></a>
				</div>
			</div>
		</div>
			<div id="blog-message">
				<?php echo $row["Blog"]; echo "</div></div></div>";}}?>
<div id="paging">
<?php
$select2="select * from blogs where username='".$_SESSION["user"]."'";
$query2=mysqli_query($con2,$select2);
$count=mysqli_num_rows($query2);
$recperpage=1;
$pages=$count/1;
for($i=1;$i<=$pages;$i++)
{
	?><a href="myblog.php?page=<?php echo $i;?>"><?php echo $i;?></a>
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