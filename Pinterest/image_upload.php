<?php 
error_reporting(E_ALL ^ E_NOTICE);
session_start();
require_once('database.php');
if (isset($_FILES["avatar"]["name"]) && $_FILES["avatar"]["tmp_name"] != ""){
	$fileName = $_FILES["avatar"]["name"];
    $fileTmpLoc = $_FILES["avatar"]["tmp_name"];
	$fileType = $_FILES["avatar"]["type"];
	$fileSize = $_FILES["avatar"]["size"];
	$fileErrorMsg = $_FILES["avatar"]["error"];
	$kaboom = explode(".", $fileName);
	$fileExt = end($kaboom);
	$db_file_name = rand(100000000000,999999999999).".".$fileExt;
	if($fileSize > 1048576) {
		echo "Your image file was larger than 2mb";
		exit();	
	} else if (!preg_match("/\.(gif|jpg|png)$/i", $fileName) ) {
		echo "Your image file was not jpg, gif or png type";
		exit();
	} else if ($fileErrorMsg == 1) {
		echo "An unknown error occurred";
		exit();
	}
	$id=$_SESSION["user"]["id"];
	$sql ='SELECT * FROM user WHERE userid="$id"';
	$query = mysql_query($sql,$con);
	$row = mysql_fetch_row($query);
	$avatar = $row[5];
	if($avatar != ""){
		$picurl = "images/$avatar"; 
	    if (file_exists($picurl)) { unlink($picurl); }
	}
	$moveResult = move_uploaded_file($fileTmpLoc,"images/$db_file_name");
	if ($moveResult != true) {
		echo "File upload failed";
		exit();
	}
	include_once("image_resize.php");
	$target_file = "../user/$log_username/$db_file_name";
	$resized_file = "../user/$log_username/$db_file_name";
	$wmax = 200;
	$hmax = 200;
	img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
	$sql = "UPDATE user SET profilepic='$db_file_name' WHERE userid='$id'";
	mysql_query($sql,$con);
	header('Location:profile.php');
	exit();
}
?>