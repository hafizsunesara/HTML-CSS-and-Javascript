<?php
session_start();
require_once('database.php');
if(!empty($_POST['url']))
	{
	$url=$_POST['url'];
	$tag=$_POST['tag'];
	$boardid=$_POST['board'];
	$title=$_POST['title'];
	$description=$_POST['description'];
	$kaboom = explode(".",$url);
	$fileExt = end($kaboom);
	$db_file_name = rand(100000000000,999999999999).".".$fileExt;
	$image= file_get_contents($url);
		if($image)
		{
		file_put_contents("images/".$db_file_name,$image);
		include_once("image_resize.php");
		$target_file = "images/$db_file_name";
		$resized_file = "images/$db_file_name";
		$wmax = 200;
		$hmax = 200;
		img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
		}
		else echo "error loading image";
	$photo="insert into photo values(default,'$title','$description','$db_file_name','$url')";
	mysql_query($photo,$con);
	$retrieve ="SELECT max(photoid) FROM photo WHERE title='$title'";
	$result= mysql_query($retrieve,$con);
	$row = mysql_fetch_row($result);
	$photoid= $row[0];
	$sql = "insert into pin VALUES(default,'$boardid','$photoid','$tag',default)";
	mysql_query($sql,$con);
	//header('Location:pin.php');
	exit();
	}
else
echo "no entry";
?>