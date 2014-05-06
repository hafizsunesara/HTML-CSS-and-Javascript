<?php session_start();
	include 'database.php';
	$uid=$_SESSION['user']['id'];
	$count = mysql_query("select count(*) from friend where (user1id='$uid' AND status=1) OR (user2id='$uid' AND status=1) ",$con);
	if($count==null)
	$friendcount[0]='0';
	else $friendcount=mysql_fetch_array($count);
	$result = mysql_query("select * from board where userid='$uid'",$con);
	$count = mysql_query("select count('boardid') from board where userid='$uid'",$con);
	$boardcount=mysql_fetch_array($count);
	$count = mysql_query("SELECT count(*) FROM  `photolike` WHERE userid=$uid and pinlike=1 limit 1",$con);
	if($count==null)
	$likecount[0]='0';
	else $likecount=mysql_fetch_array($count);
	$count = mysql_query("select count(pinid) from photo join pin using(photoid) join board using(boardid) where userid=$uid;",$con);
	if($count==null)
	$pincount[0]='0';
	else $pincount=mysql_fetch_array($count);
	$count = mysql_query("select count(pinid) from repin where boardid in (select boardid from board where userid=$uid)",$con);
	if($count==null)
	$repincount[0]='0';
	else $repincount=mysql_fetch_array($count);
	$pincount[0]=$pincount[0]+$repincount[0];
    $string="<select name='board'>";
	
    while ($row = mysql_fetch_assoc($result)) {
				unset($id, $name);
                  $id = $row['boardid'];
                  $name = $row['boardname']; 
                  $string .= '<option value="'.$id.'">'.$name.'</option>';

	}
	$string .= "</select></br>";
 ?>
<HTML>
<HEAD>
<link rel="stylesheet" type="text/css" href="design.css">
<script>
function follow()
{
var content= '<form id="avatar_form" enctype="multipart/form-data" method="post" action="create_stream.php"><h4>Create a FollowStream</h4><input type="text" name="streamname" placeholder="Follow Stream Title"></br><p><input type="submit" value="Create a Stream" class="upload"></p></form>';
var box_content='<div id="overlay"><div id="box_frame"><div id="box"><div id="cancelbutton"><a href="javascript:close()" ><img src="images/cancel_button.png" width="20" height="20" ></a></div>'+content+'</div></div></div>';
document.getElementById("dialog").innerHTML=box_content;
}
function board()
{
var content= '<form id="avatar_form" enctype="multipart/form-data" method="post" action="create_board.php"><h4>Create a Board</h4><input type="text" name="boardname" placeholder="Boardname"></br><select name="category"><option value="Animals">Animals</option><option value="Architecture">Architecture</option><option value="Art">Art</option><option value="Cars & Motorcycles">Cars & Motorcycle</option><option value="Celebrities">Celebrities</option><option value="Food & Drink">Food & Drink</option><option value="Beauty">Beauty</option><option value="Health & Fitness">Health & Fitness</option><option value="travel">Travel</option><option value="Sports">Sports</option><option value="Technology">Technology</option><option value="Others">Others</option></select><label>secret:</label><input type="radio" name="secret" value="1">yes<input type="radio" name="secret" value="0">no<p><input type="submit" value="Create a Board" class="upload"></p></form>';
var box_content='<div id="overlay"><div id="box_frame"><div id="box"><div id="cancelbutton"><a href="javascript:close()" ><img src="images/cancel_button.png" width="20" height="20" ></a></div>'+content+'</div></div></div>';
document.getElementById("dialog").innerHTML=box_content;
}
function url(select)
{
var content= '<form id="avatar_form" enctype="multipart/form-data" method="post" action="url_pin.php"><h4>Pin Your Picture</h4>'+select+'<input type="text" name="url" placeholder="Paste Your URL..."></br><input type="text" id="title" name="title" placeholder="Image Title"></br><input type="textarea" id="description" name="description" placeholder="Description..."></br><input type="text" id="tag" name="tag" placeholder="ex: pie recipes skiing"><p><input type="submit" value="Pin it" class="upload"></p></form>';
var box_content='<div id="overlay"><div id="box_frame"><div id="box"><div id="cancelbutton"><a href="javascript:close()" ><img src="images/cancel_button.png" width="20" height="20" ></a></div>'+content+'</div></div></div>';
document.getElementById("dialog").innerHTML=box_content;
}
function dialog(select)
{
var content= '<form id="avatar_form" enctype="multipart/form-data" method="post" action="image_pin.php"><h4>Pin Your Picture</h4>'+select+'<input type="file" name="avatar" required></br><input type="text" id="title" name="title" placeholder="Image Title"></br><input type="textarea" id="description" name="description" placeholder="Description..."></br><input type="text" id="tag" name="tag" placeholder="ex: pie recipes skiing"><p><input type="submit" value="Pin it" class="upload"></p></form>';
var box_content='<div id="overlay"><div id="box_frame"><div id="box"><div id="cancelbutton"><a href="javascript:close()" ><img src="images/cancel_button.png" width="20" height="20" ></a></div>'+content+'</div></div></div>';
document.getElementById("dialog").innerHTML=box_content;
}
function close(){
document.getElementById("dialog").innerHTML= '';
}
</script>
</HEAD>
<BODY>
<DIV id="banner">
<form name="search" action="search.php">
<input type="text" name="search" placeholder="eg. ski,holidays..." style="positon:fixed;left:3%;margin:6px;width:15%;border:1px solid #333;border-radius:5px">
<select name="table" style="position:fixed;top:1px;left:15.6%;margin:6px;width:5%;border:1px solid #333;border-radius:5px"><option value="pin">Pins</option><option value="board">Boards</option><option value="user">Users</option></select>
<input type="submit" value="" style="margin:5px;width:25px;height:25px;border:1px solid #333;border-radius:5px;position:fixed;top:2px;left:20.7%;background-image:url('images/searchbutton.jpg');background-repeat:no-repeat;background-size:100% 100%;">
</form>
<div id="banner-logo"><img src="images/logo.jpg" width="100" height="30" id="banner-logo" style="top:1%;position:fixed"></div>
<div id="add">
<?php echo '<ul id="addmenu">
	<li>
	<img src="images/add.jpg" width="30" height="30" >
		<ul> 
			
            <li><a href="javascript:dialog(\''. addslashes(htmlspecialchars($string)) .'\')">Upload</a></li>
            <li><a href="javascript:url(\''. addslashes(htmlspecialchars($string)) .'\')">From Web</a></li>
            <li><a href="javascript:board()">New Board</a></li>
			<li><a href="javascript:follow()">New Stream</a></li>
        </ul>
	</li>
</ul>
<ul id="home" style="padding-left:1%;padding-right:1%;padding-bottom:0.1%">
	<li>
	<a href="profile.php"><label>'.strtolower($_SESSION["user"]["firstname"]) .'</label></a>
		<ul> 
			
            <li><a href="board.php">Your Boards('.$boardcount[0].')</a></li>
            <li><a href="pin.php">Your Pins</a></li>
            <li><a href="">Your Friends('.$friendcount[0].')</a></li>
			<li><a href="pin.php?likes">Your Likes('.$likecount[0].')</a></li>
			<li><a href="board.php?follow">Follow Stream</a></li>
			<li><a href="logout.php">Logout</a></li>
        </ul>
	</li>
</ul>'
?>
</div>
<div id="notification"><a href="search.php?table=notification"><img src="images/notificationbutton.jpg" width="28" height="28" style="position:fixed;top:1%;right:2%;margin:auto"></a></div>
</DIV>

</BODY>
</HTML>
