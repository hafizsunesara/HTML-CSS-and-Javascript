<?php 
	session_start();
	require_once('database.php');
	if(!empty($_POST['boardname']))
	{
	$boardname=$_POST['boardname'];
	$category=$_POST['category'];
	$secret=$_POST['secret'];
	$id=$_SESSION['user']['id'];
	echo $id;
	$board="INSERT INTO board VALUES(default,'$id','$boardname','$category','$secret')";
	mysql_query($board,$con);
	header('Location:board.php');
	}
?>