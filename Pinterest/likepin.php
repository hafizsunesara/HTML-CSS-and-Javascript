<?php
session_start();
include 'database.php';
if(isset($_GET['action']))
if($_GET['action']==='like')
{
$photoid=$_GET['photoid'];
$uid=$_SESSION['user']['id'];
$likepin="Insert into `photolike` VALUES($photoid,$uid,1,default)";
$result=mysql_query($likepin,$con); if(false == $result) echo mysql_error();
header('Location: ' . $_SERVER['HTTP_REFERER']);
}
if($_GET['action']==='dislike')
{
$photoid=$_GET['photoid'];
$uid=$_SESSION['user']['id'];
$likepin="DELETE FROM `photolike` where photoid=$photoid and userid=$uid";
$result=mysql_query($likepin,$con); if(false == $result) echo mysql_error();
header('Location: ' . $_SERVER['HTTP_REFERER']);
}
if($_GET['action']==='delete')
{
$pinid=$_GET['pinid'];
$delpin="DELETE FROM `pin` where pinid=$pinid";
$result=mysql_query($delpin,$con); if(false == $result) echo mysql_error();
header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>