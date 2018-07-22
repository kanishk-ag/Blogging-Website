<?php
session_start();
if(isset($_SESSION["admin"]))
{
$id=$_GET["id"];
$con=mysqli_connect('localhost','kanishk11','kanishk11');
mysqli_select_db($con,"blog");
$query2="select Username from users where ID='".$id."'";
$result2=mysqli_query($con,$query2);
$row=mysqli_fetch_assoc($result2);
$username=$row["Username"];
$query="Delete from users where ID='".$id."'";
$result=mysqli_query($con,$query);
$query3="delete from blogs where Username='".$username."'";
$deleteblogs=mysqli_query($con,$query3);
if($result && $deleteblogs)
{
	header('Location: adminviewusers.php');
	$_SESSION["deleteduser"]="yes";
	exit();
}
else
{
	echo "Couldnt be deleted".mysqli_error($con);
}
mysqli_close($con);
}
else
{
	header("Location: adminlogin.php");
}
?>