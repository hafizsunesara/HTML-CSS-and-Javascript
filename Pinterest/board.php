<HTML>
<?php
require_once('database.php');?>
<HEAD>
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title></title>

	<link rel="stylesheet" type="text/css" href="styles.css" />
    <link href='http://fonts.googleapis.com/css?family=Cambo' rel='stylesheet' type='text/css'>
	
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="script.js"></script>

	
</head>
<body onload="setupBlocks();">
	<?php require'banner.php';?>
	<div id="frame">
	
	<?php
	if(!isset($_GET['streamid'])&&!isset($_GET['follow']))
	{
	echo '<h3>Your Boards</h3>';
	$id=$_SESSION['user']['id'];
	$result=mysql_query("select * from board where userid='$id'",$con);
	
	if (false === $result) {
    echo mysql_error();
}
	while($row=mysql_fetch_array($result)){$boardimg=mysql_query("SELECT * FROM photo join pin using(photoid) WHERE boardid=$row[0] order by pintime desc limit 1",$con);$image= mysql_fetch_array($boardimg);?>
    <div class="block">
	<div id="dialog"></div>
	<?php
	if($image[3]==null) $image[3]="defaultboard.jpg";
	echo '<a href=pin.php?boardid='.$row['boardid'].'&name='.$row['boardname'].'><img src="images/' . $image[3] . '" width="200" height="200"><a href=pin.php?boardid='.$row['boardid'].'&name='.$row['boardname'].'>'.$row['boardname'].'</a><br>'.$row['category'];?>
    </div>
	<?php } }?>
	<?php
	if(isset($_GET['streamid']))
	{
	echo '<h3>Stream</h3>';
	$id=$_SESSION['user']['id'];
	$stream=$_GET['streamid'];
	$result=mysql_query("select * from board where boardid in (select boardid from stream where streamid=$stream)",$con);
	
	if (false === $result) {
    echo mysql_error();
}
	while($row=mysql_fetch_array($result)){
	$boardimg=mysql_query("SELECT * FROM photo join pin using(photoid) WHERE boardid=$row[0] order by pintime desc limit 1",$con);$image= mysql_fetch_array($boardimg);?>
    <div class="block">
	<div id="dialog"></div>
	<?php
	if($image[3]==null) $image[3]="defaultboard.jpg";
	echo '<a href=pin.php?boardid='.$row['boardid'].'&name='.$row['boardname'].'><img src="images/' . $image[3] . '" width="200" height="200"><a href=pin.php?boardid='.$row['boardid'].'&name='.$row['boardname'].'>'.$row['boardname'].'</a><br>'.$row['category'];?>
    </div>
	<?php } }?>
		<?php
	if(isset($_GET['follow']))
	{
	echo '<h3>Follow Stream</h3>';
	$id=$_SESSION['user']['id'];
	$result=mysql_query("select * from followstream where userid=$id",$con);
	
	if (false === $result) {
    echo mysql_error();
}
	while($row=mysql_fetch_array($result)){
	$boardimg=mysql_query("SELECT * FROM photo join pin using(photoid) WHERE boardid in (select boardid from followstream join stream using(streamid) where userid=$id ) order by pintime desc limit 1",$con);$image= mysql_fetch_array($boardimg);?>
    <div class="block">
	<div id="dialog"></div>
	<?php
	if($image[3]==null) $image[3]="defaultboard.jpg";
	echo '<a href=board.php?streamid='.$row['streamid'].'&name='.$row['streamname'].'><img src="images/' . $image[3] . '" width="200" height="200"><a href=board.php?streamid='.$row['streamid'].'&name='.$row['streamname'].'>'.$row['streamname'].'</a>';?>
    </div>
	<?php } }?>
	</div> 
</body>
</HTML>
