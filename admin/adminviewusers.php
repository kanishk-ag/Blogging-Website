<?php
session_start();
if(isset($_SESSION["admin"]))
{
$con=mysqli_connect('localhost','kanishk11','kanishk11') or die("Couldnt connect");
mysqli_select_db($con,"blog");
$query="select * from users order by ID";
$exec=mysqli_query($con,$query);
$query2="select count(Username) as usercount from users";
$exec2=mysqli_query($con,$query2);
$totalusers=mysqli_fetch_assoc($exec2);
$query3="select count(Blog) as blogcount from blogs";
$exec3=mysqli_query($con,$query3);
$totalblogs=mysqli_fetch_assoc($exec3);
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/adminpanel.css">
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
	<script>
		$("document").ready(function(){
			$("#deleteuser").click(function(){
				if(!confirm('Are you sure to remove this record ?'))
				{
					$('#deleteuser').removeAttr('href');
					location.reload();
				}
				else
				{
					$('#deleteuser').attr('href','admindeleteuser.php?id=".$result["ID"]."');
				}
			});
			$("#blockuser").click(function(){
				if(!confirm('Are you sure to remove this record ?'))
				{
					$('#blockuser').removeAttr('href');
					location.reload();
				}
				else
				{
					$('#blockuser').attr('href','adminblockuser.php?id=".$result["ID"]."');
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
		<p>Welcome Admin</p>
	</div>			
	<div id="count">
		<div id="user-count">
			No. Of Users: <?php echo $totalusers["usercount"];?>
		</div>
		<div id="blog-count">
			No. Of Blogs: <?php echo $totalblogs["blogcount"];?>
		</div>
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
	<div id="heading">
	<p>Manage Users</p>
	</div>
	<div id="notify">
		<p>
	<?php	
	if(isset($_SESSION["deleteduser"]))
	{
		echo "User deleted";
		$_SESSION["deleteduser"]=null;
	}
	if($_SESSION["blockeduser"]=="yes")
	{
		echo "User blocked";
		$_SESSION["blockeduser"]=null;
	}
	if($_SESSION["blockeduser"]=="no")
	{
		echo "User unblocked";
		$_SESSION["blockeduser"]=null;
	}
	if(isset($_SESSION["updated"]))
	{
		echo "User details updated";
		$_SESSION["updated"]=null;
	}
	?>
	</p>
	</div>
	<div id="alert">
		<p>The user is deleted</p>
	</div>
	<div id=table-div>
		<table>
			<tr>
				<th>Name</th>
				<th>Username</th>
				<th>Age</th>
				<th>Gender</th>
				<th>Email</th>
				<th>View Blogs</th>
				<th>Blocked</th>
				<th>Delete</th>
				<th>Edit Details</th>
			</tr>
			<?php while($result=mysqli_fetch_assoc($exec))
			{
				if($result['Blocked']=='Yes')
				{
				echo "<tr><td>".$result["Name"]."</td><td>".$result["Username"]."</td><td>".$result["Age"]."</td><td>".$result["Gender"]."</td><td>".$result["Email"]."</td><td><a href='adminviewuserblogs.php?username=".$result['Username']."&page=1'><img src='../images/view-icon.png' style='width:40px;height:40px;margin-left:10px;'></td><td><a href='adminblockuser.php?id=".$result["ID"]."&blocked=No' id='blockuser'><img src='../Images/locked-icon.png'></a></td><td><a href='admindeleteuser.php?id=".$result["ID"]."' id='deleteuser'><img src='../images/delete.png'></a></td><td><a href='adminedituser.php?id=".$result["ID"]."'><img src='../images/edit-icon.png'></a></td></tr>";
				}
				else if($result['Blocked']=='No')
				{
				echo "<tr><td>".$result["Name"]."</td><td>".$result["Username"]."</td><td>".$result["Age"]."</td><td>".$result["Gender"]."</td><td>".$result["Email"]."</td><td><a href='adminviewuserblogs.php?username=".$result['Username']."&page=1'><img src='../images/view-icon.png' style='width:40px;height:40px;margin-left:10px;'></td><td><a href='adminblockuser.php?id=".$result["ID"]."&blocked=Yes' id='blockuser'><img src='../Images/unlocked-icon.png'></a></td><td><a id='deleteuser' href='admindeleteuser.php?id=".$result["ID"]."'><img src='../images/delete.png'></a></td><td><a href='adminedituser.php?id=".$result["ID"]."'><img src='../images/edit-icon.png'></a></td></tr>";
				}
			}
			?>
		</table>
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
