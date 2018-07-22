<?php
session_start();
if(isset($_SESSION["admin"]))
{
$id=$_GET["id"];
$con=mysqli_connect("localhost","kanishk11","kanishk11");
mysqli_select_db($con,"blog");
$query="delete from blogs where ID='".$id."'";
$result=mysqli_query($con,$query);
if($result)
{
	header("Location: adminviewblogs.php?page=1");
	exit();
}
else
{
	echo "Cant be Deleted".mysqli_error($con);
}
mysqli_close($con);
}
else
{
	header("Location: adminlogin.php");
	exit();
}