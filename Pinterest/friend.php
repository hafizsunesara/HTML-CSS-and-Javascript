<?php
session_start();
require_once('database.php');
if($_GET['action']=='friend')
{
$loggeduser=$_SESSION['user']['id'];
$touser=$_GET['user'];
$query="insert into friend values('$loggeduser','$touser',default,default,default)";
mysql_query($query,$con);
header('Location: ' . $_SERVER['HTTP_REFERER']);
}
if($_GET['action']==='unfriend')
{
$loggeduser=$_SESSION['user']['id'];
$touser=$_GET['user'];
$query="delete from friend where (user1id='$loggeduser' AND user2id='$touser') OR (user1id='$touser' AND user2id='$loggeduser')";
mysql_query($query,$con);
header('Location: ' . $_SERVER['HTTP_REFERER']);
}
if($_GET['action']==='accept')
{
$loggeduser=$_SESSION['user']['id'];
$touser=$_GET['user'];
$query="update friend set status=1,responsetime=now() where (user1id='$loggeduser' AND user2id='$touser') OR (user1id='$touser' AND user2id='$loggeduser')";
//echo $query;
mysql_query($query,$con);
header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>