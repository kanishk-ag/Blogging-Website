<?php
session_start();
if(isset($_SESSION["admin"]))
{
$con=mysqli_connect("localhost","kanishk11","kanishk11");
mysqli_select_db($con,"blog");
$id=$_GET["id"];
$blocked=$_GET["blocked"];
if($blocked=="No")
{
	$query="update users set Blocked='No' where ID='".$id."'";
	$_SESSION["blockeduser"]="no";
}
else if($blocked=="Yes")
{
	$query="update users set Blocked='Yes' where ID='".$id."'";
	$_SESSION["blockeduser"]="yes";
}
$result=mysqli_query($con,$query);
if($result)
{
	header("Location: adminviewusers.php");
	exit();
}
else
{
	echo "Cant be changes".mysqli_error($con);
}
mysqli_close($con);
}
else
{
	header("Location: adminlogin.php");
}
?>