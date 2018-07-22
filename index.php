<?php
session_start();
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/styleindex.css">
</head>
<body>
	<div id="header">
		<div id="notify">
			<?php
				if(isset($_SESSION["accountcreated"]))
				{
					echo "Account created";
					$_SESSION["accountcreated"]=null;
				}
			?>
		</div>
		<div id="header-text">
			Blogger		
		</div>
	</div>
	<div id="logo">
		<img src="images/blogging2.png">
	</div>
		<div id="login-box">
			<form name="form1" action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
			<div id="username">
				<input type="text" name="user" id="username-input" placeholder="Username" >
			</div>
			<div id="password">
				<input type="password" name="password" placeholder="Password" id="password-input" >
			</div>
			<div id="login-buttondiv">
				<input type="submit" name="submit" id="login-button" value="LOGIN">
			</div>
			</form>
			<div id="new-user">
				<a href="new user.php">Sign Up</a>	
			</div>
		</div>
</body>
</html>
<?php
if(isset($_GET["submit"]))
{
	if(empty($_GET["user"]))
	{
		echo "<script>alert('Enter Username');</script>";
	}
	else if(empty($_GET["password"]))
	{
		echo "<script>alert('Enter Password');</script>";
	}
	else
	{
	$_SESSION["user"]=$_GET["user"];
	$_SESSION["pass"]=$_GET["password"];
	$con=mysqli_connect("localhost","kanishk11","kanishk11") or die("connection fail");
	mysqli_select_db($con,"blog");
	$query="Select * from users where Username='".$_SESSION["user"]."' and Password='".$_SESSION["pass"]."'";
	$result=mysqli_query($con,$query);
	
	if(!$result || mysqli_num_rows($result)==0)
	{
		echo "<script>alert('Invalid username or password');</script>";
	}
	else
	{	$row=mysqli_fetch_assoc($result);
		if($row["Blocked"]=="Yes")
		{
			echo "<script>alert('The user is blocked');</script>";
		}
		else
		{
		header("Location: userpage.php?page=1");  
		exit();	
		}
	}
	mysqli_close($con);
}
}
?>