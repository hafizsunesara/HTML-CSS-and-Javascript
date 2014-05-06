<HTML>
<?php require_once('database.php'); ?>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title></title>

	<link rel="stylesheet" type="text/css" href="styles.css" />
    <link href='http://fonts.googleapis.com/css?family=Cambo' rel='stylesheet' type='text/css'>
	
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="script.js"></script>
	<script>
	function stream(select)
	{
	var content= '<form id="stream_form" enctype="multipart/form-data" method="post" action="create_stream.php"><h4>Add Stream</h4>'+select+'&nbsp<p><input type="submit" value="Confirm" class="upload"></p></form>';
	var box_content='<div id="overlay"><div id="box_frame"><div id="box"><div id="cancelbutton"><a href="javascript:close()" ><img src="images/cancel_button.png" width="20" height="20" ></a></div>'+content+'</div></div></div>';
	document.getElementById("dialog").innerHTML=box_content;
	}
	function repin(select)
	{
	var content= '<form id="repin_form" enctype="multipart/form-data" method="post" action="create_stream.php"><h4>Repin</h4>'+select+'<p><input type="submit" value="Pin it!" class="upload"></p></form>';
	var box_content='<div id="overlay"><div id="box_frame"><div id="box"><div id="cancelbutton"><a href="javascript:close()" ><img src="images/cancel_button.png" width="20" height="20" ></a></div>'+content+'</div></div></div>';
	document.getElementById("dialog").innerHTML=box_content;
	}
	function close(){
	document.getElementById("dialog").innerHTML= '';
	}
	</script>
</HEAD>
<BODY onload="setupBlocks();">
<?php require'banner.php';?>
<div id="frame">
<?php 
$uid=$_SESSION['user']['id'];
if(isset($_GET['search']))
$tag=$_GET['search'];
if($_GET['table']==='pin')
{
echo '<h3>Search Results</h3>';
$search="select * from pin join photo using(photoid) where tag like '%$tag%' or title like '%$tag%'"; 
$research="select * from pin join photo using(photoid) where pinid in (select pinid from repin where tag like '%$tag%')";
$result=mysql_query($search,$con);
$reresult=mysql_query($research,$con);
if (false == $result) {
    echo mysql_error();
}
while($row=mysql_fetch_array($result))
{
$pid=$row['pinid'];
$repin = mysql_query("select * from board where userid='$uid' AND boardid not in (select boardid from repin where pinid='$pid')",$con);
$unstring = '<img src="images/' . $row['path'] . '" width="200" height="200">&nbsp';
$unstring .="<select name='repin'>";
while ($unfollow = mysql_fetch_assoc($repin)) {
unset($id, $name);
$id = $unfollow['boardid'];
$name = $unfollow['boardname']; 
$unstring .= '<option value="'.$id.'">'.$name.'</option>';
}
$unstring .= "</select>&nbsp"; 
$unstring .='<input type="hidden" name="pinid" value="'.$row['pinid'].'"><input type="text" id="tag" name="tag" placeholder="ex: pie recipes skiing">'; 
$bid=$row['boardid'];  
$board=mysql_fetch_row(mysql_query("select * from board where boardid=$bid",$con));
	
	echo '<div class="block">'; 
		//echo $board[2];
		echo $row['title'].'&nbsp<div class="show-image"><a href="javascript:repin(\''. addslashes(htmlspecialchars($unstring)) .'\')"><img src="images/repinbutton.jpg" width="75" height="30" class="the-buttons"></a><img src="images/' . $row['path'] . '" width="200" height="200"></div><a href="pin.php?boardid='.$bid.'&name='.$board[2].'">'.$board[2].'</a>'; 
		echo '</div>';
}
while($row=mysql_fetch_array($reresult))
{
$pid=$row['pinid'];
$repin = mysql_query("select * from board where userid='$uid' AND boardid not in (select boardid from repin where pinid='$pid')",$con);
$unstring = '<img src="images/' . $row['path'] . '" width="200" height="200">&nbsp';
$unstring .="<select name='repin'>";
while ($unfollow = mysql_fetch_assoc($repin)) {
unset($id, $name);
$id = $unfollow['boardid'];
$name = $unfollow['boardname']; 
$unstring .= '<option value="'.$id.'">'.$name.'</option>';
}
$unstring .= "</select>&nbsp"; 
$unstring .='<input type="hidden" name="pinid" value="'.$row['pinid'].'"><input type="text" id="tag" name="tag" placeholder="ex: pie recipes skiing">'; 
$bid=$row['boardid'];  
$board=mysql_fetch_row(mysql_query("select * from board where boardid=$bid",$con));
	
	echo '<div class="block">'; 
		//echo $board[2];
		echo $row['title'].'&nbsp<div class="show-image"><a href="javascript:repin(\''. addslashes(htmlspecialchars($unstring)) .'\')"><img src="images/repinbutton.jpg" width="75" height="30" class="the-buttons"></a><img src="images/' . $row['path'] . '" width="200" height="200"></div><a href="pin.php?boardid='.$bid.'&name='.$board[2].'">'.$board[2].'</a>'; 
		echo '</div>';
}
}
if($_GET['table']==='board')
{
echo '<h3>Search Results</h3>';
$search="select * from board where boardname like '%$tag%' or category like '%$tag%'";
$result=mysql_query($search,$con);
if (false == $result) {
    echo mysql_error();
}
if(mysql_num_rows($result)==0)
echo '<h3>Empty</h3>';
else
{
while($row=mysql_fetch_array($result))
{
$stream = mysql_query("select * from followstream where userid='$uid' AND streamid not in(select streamid from stream where boardid=$row[0])",$con);
$string="<select name='stream'>";
while ($follow = mysql_fetch_assoc($stream)) {
unset($id, $name);
$id = $follow['streamid'];
$name = $follow['streamname']; 
$string .= '<option value="'.$id.'">'.$name.'</option>';
}
$string .= "</select></br>"; 
$string .='<input type="hidden" name="boardid" value="'.$row['boardid'].'">';
$unstream = mysql_query("select * from followstream where userid='$uid' AND streamid in(select streamid from stream where boardid=$row[0])",$con);
$unstring="<select name='unstream'>";
while ($unfollow = mysql_fetch_assoc($unstream)) {
unset($id, $name);
$id = $unfollow['streamid'];
$name = $unfollow['streamname']; 
$unstring .= '<option value="'.$id.'">'.$name.'</option>';
}
$unstring .= "</select></br>"; 
$unstring .='<input type="hidden" name="boardid" value="'.$row['boardid'].'">';
$boardimg=mysql_query("SELECT * FROM photo join pin using(photoid) WHERE boardid=$row[0] order by pintime desc limit 1",$con);$image= mysql_fetch_array($boardimg);
	
	echo '<div class="block">';
	echo '<a href="javascript:stream(\''. addslashes(htmlspecialchars($string)) .'\')"><img src="images/followbutton1.jpg" height="30" width="100"></a>&nbsp';
	echo '<a href="javascript:stream(\''. addslashes(htmlspecialchars($unstring)) .'\')"><img src="images/unfollowbutton.jpg" height="30" width="100"></a>&nbsp';
	if($image[3]==null) $image[3]="defaultboard.jpg";
	echo '<a href=pin.php?boardid='.$row['boardid'].'&name='.$row['boardname'].'><img src="images/' . $image[3] . '" width="200" height="200"><a href=pin.php?boardid='.$row['boardid'].'&name='.$row['boardname'].'>'.$row['boardname'].'</a><br>'.$row['category'];
    echo '</div>';
	} ?>
<?php } }
if($_GET['table']==='user')
{
echo '<h3>Search Results</h3>';
$uid=$_SESSION['user']['id'];
$search="select * from user where (firstname like '%$tag%' or lastname like '%$tag%') and userid!=$uid";
$result=mysql_query($search,$con);
if (false == $result) {
    echo mysql_error();
}
if(mysql_num_rows($result)==0)
echo '<h3>Empty</h3>';
else
{
while($row=mysql_fetch_array($result))
{
	echo '<div class="block">';
	if($row['profilepic']==null) { if($row['sex']=='male') $profile_pic = '<img src="images/defaultmen.jpg" width="200" height="200">'; else $profile_pic = '<img src="images/defaultwomen.jpg" width="200" height="200">';}
	else  $profile_pic='<img src="images/'.$row['profilepic'].'" width="200" height="200">';
	echo $profile_pic.'<a href="profile.php?user='.$row['userid'].'">'.strtolower($row['firstname'])." ".strtolower($row['lastname']).'</a>';
	echo '</div>';
	} } }
if($_GET['table']==='notification')
{
echo '<h3>Notification</h3>';
$uid=$_SESSION['user']['id'];
$search="select * from user where userid in (select user1id from friend where user2id='$uid' AND status=0)";
$result=mysql_query($search,$con);
if (false == $result) {
    echo mysql_error();
}
if(mysql_num_rows($result)==0)
echo '<h3>Empty</h3>';
else
{
while($row=mysql_fetch_array($result))
{
	echo '<div class="block">';
	echo '<a href="friend.php?action=accept&user='.$row['userid'].'"><img src="images/acceptbutton.jpg" height="30" width="100"></a><a href="friend.php?action=unfriend&user='.$row['userid'].'"><img src="images/declinebutton.jpg" height="30" width="100"></a>&nbsp';
	if($row['profilepic']==null) { if($row['sex']=='male') $profile_pic = '<img src="images/defaultmen.jpg" width="200" height="200">'; else $profile_pic = '<img src="images/defaultwomen.jpg" width="200" height="200">';}
	else  $profile_pic='<img src="images/'.$row['profilepic'].'" width="200" height="200">';
	echo $profile_pic.'<a href="profile.php?user='.$row['userid'].'">'.strtolower($row['firstname'])." ".strtolower($row['lastname']).'</a>';
	echo '</div>';
	} }}?>
<div id="dialog"></div>
</div> 
</BODY>
</HTML>