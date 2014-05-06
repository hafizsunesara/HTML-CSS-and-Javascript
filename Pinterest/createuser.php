<?php
session_start();
if($_SESSION['access']==='true')
{
require 'database.php';
$emailid=$_POST['email'];
$fname=$_POST['firstname'];
$lname=$_POST['lastname'];
$password=md5($_POST['password']);
$repassword=md5($_POST['repassword']);
$sex=$_POST['sex'];
$country=$_POST['country'];
if(empty($emailid)||empty($fname)||empty($lname)||empty($password)||empty($repassword)||empty($sex)||empty($country))
{
echo '<script language="javascript">';
echo 'alert(" Please Enter All the Details")';
//echo 'document.location.href = "signup.php"';
echo '</script>'; 

}
if($password!==$repassword)
{
echo '<script language="javascript">';
echo 'alert("password mismatch")';
//echo 'document.location.href = "signup.php"';
echo '</script>';

}
$result=mysql_query("Select * from user where email='$emailid'",$con);
$rows=mysql_num_rows($result);
	if($rows=='0')
	{
	mysql_query("INSERT INTO user VALUES(default, '$emailid', '$fname', '$lname', '$password',default, '$sex', '$country',default)",$con);
	$query=mysql_query("Select * from user where email='$emailid'",$con);
	$user=mysql_fetch_array($query);
	$_SESSION['user']['id']=$user['userid'];
	$id=$_SESSION['user']['id'];
	$_SESSION['user']['firstname']=$user['firstname'];
	$_SESSION['user']['lastname']=$user['lastname'];
	$board="INSERT INTO board VALUES(default,'$id','sample','sample',default)";
	mysql_query($board,$con);
	$stream="INSERT INTO followstream VALUES(default,'$id','default',default)";
	mysql_query($stream,$con);
	header('Location:profile.php');
	}
	else
	{
	echo '<script language="javascript">';
	echo 'alert(" User Already Exist")';
	//echo 'window.location="signup.php"';
	echo '</script>';
	}

}
else
{
header('Location:signup.php');
}
?>