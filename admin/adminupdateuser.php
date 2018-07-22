<?php
session_start();
if(isset($_SESSION["admin"]))
{
$con=mysqli_connect('localhost','kanishk11','kanishk11') or die("Couldnt connect");
mysqli_select_db($con,"blog");
if(isset($_POST["submit"]))
{
	$name=$_POST["name"];
	$age=$_POST["age"];
	$email=$_POST["email"];
	$gender=$_POST["gender"];
	$password=$_POST["password"];
	$username=$_POST["username"];
	$query1="update users set Name='".$name."',Age='".$age."',Email='".$email."',Gender='".$gender."',Password='".$password."' where Username='".$username."'";
	$result1=mysqli_query($con,$query1);
	if(!$result1)
	{
		echo "Values cant be updated".mysqli_error($con);
	}
	else
	{
		header('Location: adminviewusers.php');
		$_SESSION["updated"]="true";
		exit();
	}
	mysqli_close($con);
}
}
else
{
	header("Location: adminlogin.php");
}
?>