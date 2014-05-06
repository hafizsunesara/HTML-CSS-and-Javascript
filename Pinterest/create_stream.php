<?php 
	session_start();
	require_once('database.php');
	if(!empty($_POST['streamname']))
	{
	$streamname=$_POST['streamname'];
	$id=$_SESSION['user']['id'];
	$stream="INSERT INTO followstream VALUES(default,'$id','$streamname',default)";
	echo $stream;
	mysql_query($stream,$con);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	if(!empty($_POST['stream']))
	{
	$streamid=$_POST['stream'];
	$boardid=$_POST['boardid'];
	$follow="insert into stream values($streamid,$boardid)";
	echo $follow;
	mysql_query($follow,$con);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	if(!empty($_POST['unstream']))
	{
	$streamid=$_POST['unstream'];
	$boardid=$_POST['boardid'];
	$unfollow="delete from stream where streamid=$streamid AND boardid=$boardid";
	echo $unfollow;
	mysql_query($unfollow,$con);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	if(!empty($_POST['repin']))
	{
	$pinid=$_POST['pinid'];
	$boardid=$_POST['repin'];
	$tag=$_POST['tag'];
	$repin="insert into repin values('$pinid','$boardid','$tag',default)";
	mysql_query($repin,$con);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
?>