<?php
session_start();
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/styleadminlogin.css">
</head>
<body>
	<div id="header">
		<div id="header-text">
			Blogger	Admin
		</div>
		<p style="width: 70%;text-align:right;position: absolute;color:#c90;font-size: 40px;top:30px;right:70px;">
			Admin Login
		</p>
</div>
	<div id="login-box">
		<div id="login-form">
			<form name="form1" action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
			<div id="username">
				Username <input type="text" name="user" id="username-input" placeholder="Username" >
			</div>
			<div id="password">
				Password <input type="password" name="password" placeholder="Password" id="password-input" >
			</div>
			<div id="login-buttondiv" style="margin-top: 40px;">
				<input type="submit" name="submit" id="login-button" value="Login">
			</div>
			</form>
		</div>
	</div>
	<div id="footer">
		<div id="footer-text">
			Copyright@Kanishk agarwal
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
	$_SESSION["admin"]=$_GET["user"];
	$_SESSION["pass"]=$_GET["password"];
	$con=mysqli_connect("localhost","kanishk11","kanishk11") or die("connection fail");
	mysqli_select_db($con,"blog");
	$query="Select username,password from admin where Username='".$_SESSION["admin"]."' and Password='".$_SESSION["pass"]."'";
	$result=mysqli_query($con,$query);
	if(!$result || mysqli_num_rows($result)==0)
	{
		echo "<script>alert('Invalid username or password');</script>";
	}
	else
	{
		header("Location: adminpanel.php");  
		exit();	
	}
	mysqli_close($con);
}
}
?>