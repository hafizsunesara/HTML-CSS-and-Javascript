<?php
	session_start();
	require_once('database.php');
	if(!empty($_POST['comment']))
	{
	$pinid=$_POST['pinid'];
	$boardid=$_POST['boardid'];
	$comment=$_POST['comment'];
	$uid=$_SESSION['user']['id'];
	$comment="insert into comment values('$pinid','$boardid','$uid','$comment',default)";
	mysql_query($comment,$con);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
?>