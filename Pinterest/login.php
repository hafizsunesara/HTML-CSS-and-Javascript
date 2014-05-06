<?php
session_start();
error_reporting (1);
if($_SESSION['access']==='true')
{
require 'database.php';
$emailid=$_POST['email'];
$password=md5($_POST['password']);
$result=mysql_query("Select * from user where email='$emailid' and password='$password'",$con);
$rows=mysql_num_rows($result);
	if($rows=='1')
	{
	while($user=mysql_fetch_array($result))
	{
	$_SESSION['user']['id']=$user['userid'];
	$_SESSION['user']['firstname']=$user['firstname'];
	$_SESSION['user']['lastname']=$user['lastname'];
	header('Location:profile.php');
	}
	}
	else
	{
	echo "Invalid Email or Password";
	}
}
else
{
header('Location:signin.php');
}
?>