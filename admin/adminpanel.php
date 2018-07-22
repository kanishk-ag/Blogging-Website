<?php
session_start();
if(isset($_SESSION["admin"]))
{
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/adminpanel.css">
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
				<li><a href="adminaddnewuser.php" style="text-decoration: none;">Add New User</a></li>
				<li><a href="adminwriteblog.php" style="text-decoration: none;">Add New Blog</a></li>
				<li><a href="logout.php" style="text-decoration: none;">Logout</a></li>
			</ul>
		</div>
	<div style="margin-left: 300px; margin-top:150px;width: 30%;text-align: center;font-size: 50px; font-weight: bold;float: left;">
		Admin Panel
	</div>
</body>
</html>
<?php
}
else
{
	header("Location: adminlogin.php");
}
?>