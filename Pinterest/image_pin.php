<?php 
error_reporting(E_ALL ^ E_NOTICE);
session_start();
require_once('database.php');
if (isset($_FILES["avatar"]["name"]) && $_FILES["avatar"]["tmp_name"] != ""){
	$tag=$_POST['tag'];
	$boardid=$_POST['board'];
	$title=$_POST['title'];
	$description=$_POST['description'];
	$fileName = $_FILES["avatar"]["name"];
    $fileTmpLoc = $_FILES["avatar"]["tmp_name"];
	$fileType = $_FILES["avatar"]["type"];
	$fileSize = $_FILES["avatar"]["size"];
	$fileErrorMsg = $_FILES["avatar"]["error"];
	$kaboom = explode(".", $fileName);
	$fileExt = end($kaboom);
	$db_file_name = rand(100000000000,999999999999).".".$fileExt;
	if($fileSize > 1048576) {
		echo "Your image file was larger than 1mb";
		exit();	
	} else if (!preg_match("/\.(gif|jpg|png)$/i", $fileName) ) {
		echo "Your image file was not jpg, gif or png type";
		exit();
	} else if ($fileErrorMsg == 1) {
		echo "An unknown error occurred";
		exit();
	}
	$id=$_SESSION["user"]["id"];
	$moveResult = move_uploaded_file($fileTmpLoc,"images/$db_file_name");
	if ($moveResult != true) {
		echo "File upload failed";
		exit();
	}
	include_once("image_resize.php");
	$target_file = "images/$db_file_name";
	$resized_file = "images/$db_file_name";
	$wmax = 200;
	$hmax = 200;
	img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
	$photo="insert into photo values(default,'$title','$description','$db_file_name','uploaded')";
	mysql_query($photo,$con);
	$retrieve ="SELECT max(photoid) FROM photo WHERE title='$title'";
	$result= mysql_query($retrieve,$con);
	$row = mysql_fetch_row($result);
	$photoid= $row[0];
	$sql = "insert into pin VALUES(default,'$boardid','$photoid','$tag',default)";
	mysql_query($sql,$con);
	header('Location:pin.php');
	exit();
}
?>