<HTML>
<HEAD>
<script src="ajax.js"></script>
<script src="script.js"></script>
</HEAD>
<BODY>
<?php if(isset($_GET['user'])&&$_GET['user']!==$_SESSION['user']['id'])
{ ?>
<DIV id="content"><?php include'banner.php';?><div id="dialog"></div><STRONG>User Profile</STRONG><br>
<?php 
require_once('database.php');
$id=$_GET['user'];
$query= "Select * from user where userid='$id'";
$result=mysql_query($query,$con);
$row=mysql_fetch_array($result);
if($row['profilepic']==null) { if($row['sex']=='male') $profile_pic = '<img src="images/defaultmen.jpg" width="200" height="200">'; else $profile_pic = '<img src="images/defaultwomen.jpg" width="200" height="200">';}
else  $profile_pic='<img src="images/'.$row['profilepic'].'" width="200" height="200">';
if($id!==$_SESSION['user']['id'])
{   $uid=$_SESSION['user']['id'];
	$friendbutton = "select * from friend where (user1id='$id' AND user2id='$uid') OR (user2id='$id' AND user1id='$uid')";
	$result=mysql_query($friendbutton,$con);
	if(mysql_num_rows($result)==0)
	{
	echo '<a href="friend.php?action=friend&user='.$id.'"><img src="images/friendbutton.jpg" height="30" width="100"></a>&nbsp';
	}
	else
	{
	$button=mysql_fetch_row($result);
		if($button[2]=='0'&&$button[0]==$uid)
		{echo '<a href="friend.php?action=unfriend&user='.$id.'"><img src="images/cancelrequest.jpg" height="30" width="100"></a>&nbsp';}
		if($button[2]=='0'&&$button[1]==$uid)
		{echo '<a href="friend.php?action=accept&user='.$id.'"><img src="images/acceptbutton.jpg" height="30" width="100"></a>&nbsp<a href="friend.php?action=unfriend&user='.$id.'"><img src="images/declinebutton.jpg" height="30" width="100"></a>&nbsp';}
		if($button[2]=='1')
		{echo '<a href="friend.php?action=unfriend&user='.$id.'"><img src="images/unfriendbutton1.jpg" height="30" width="100"></a>&nbsp';}
	}
}?>
<div id="profile_pic_box"><?php echo $profile_pic; ?></div>
<DIV id="Data">
<table style="font-size: 20px;font-style: italic;">
	<tr>
		<td >name</td>
		<td ><?php echo strtolower($row['firstname'])." ".strtolower($row['lastname'])?></td>
	</tr>
	<tr>
		<td >Sex</td>
		<td ><?php echo $row['sex'] ?></td>
	</tr>
	<tr>
		<td >Country&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
		<td><?php echo $row['country'] ?></td>
	</tr>
</table>
</DIV> <?php }
else
{ ?>
<DIV id="content"><?php include'banner.php';?><div id="dialog"></div><STRONG>User Profile</STRONG>
<?php 
echo "<br>";
require_once('database.php');
$id=$_SESSION['user']['id'];
$query= "Select * from user where userid='$id'";
$result=mysql_query($query,$con);
$row=mysql_fetch_array($result);
if($row['userid']==$_SESSION['user']['id'])
{
	$profile_pic_btn = '<a href="#" onclick="return false;" onmousedown="toggleElement(\'avatar_form\')">Toggle Avatar Form</a>';
	$avatar_form  = '<form id="avatar_form" enctype="multipart/form-data" method="post" action="image_upload.php">';
	$avatar_form .=   '<h4>Change your avatar</h4>';
	$avatar_form .=   '<input type="file" name="avatar" required>';
	$avatar_form .=   '<p><input type="submit" value="Upload" class="upload"></p>';
	$avatar_form .= '</form>';
	if($row['profilepic']==null)
		{
		if($row['sex']=='male')
		$profile_pic = '<img src="images/defaultmen.jpg">'; else $profile_pic = '<img src="images/defaultwomen.jpg">';
		}
	else {$profile_pic = '<img src="images/' . $row['profilepic'] . '" width="200" height="200">';}
}	
?>

<div id="profile_pic_box"><?php echo $profile_pic_btn; ?><?php echo $avatar_form; ?><?php echo $profile_pic; ?>

  </div>
<DIV id="Data">
<table style="font-size: 20px;font-style: italic;">
	<tr>
		<td >name</td>
		<td ><?php echo strtolower($row['firstname'])." ".strtolower($row['lastname'])?></td>
	</tr>
	<tr>
		<td >Sex</td>
		<td ><?php echo $row['sex'] ?></td>
	</tr>
	<tr>
		<td >Country&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
		<td><?php echo $row['country'] ?></td>
	</tr>
</table>
</DIV> <?php } ?>
</BODY>
</HTML>	