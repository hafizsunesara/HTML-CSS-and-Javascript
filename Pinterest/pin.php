<HTML>
<?php
require_once('database.php');?>
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title></title>

	<link rel="stylesheet" type="text/css" href="design.css" />
    <link href='http://fonts.googleapis.com/css?family=Cambo' rel='stylesheet' type='text/css'>
	
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="script.js"></script>
	<script>
	function comment(select)
	{
	var content= '<form id="comment_form" enctype="multipart/form-data" method="post" action="comment.php"><h4>Comment</h4>'+select+'&nbsp<input type="textarea" rows="10" cols="40" name="comment" placeholder="Comment Here..." ><p><input type="submit" value="comment" class="upload"></p></form>';
	var box_content='<div id="overlay"><div id="box_frame"><div id="box"><div id="cancelbutton"><a href="javascript:close()" ><img src="images/cancel_button.png" width="20" height="20" ></a></div>'+content+'</div></div></div>';
	document.getElementById("dialog").innerHTML=box_content;
	}
	function close(){
	document.getElementById("dialog").innerHTML= '';
	}
	</script>

	
</head>
<body onload="setupBlocks();">
	
	<div id="frame">
	<?php require'banner.php'; ?><div id="dialog"></div>
	
	<?php  
	if(isset($_GET['boardid'])) 
	{
	echo '<h3>'.$_GET["name"].'</h3>';
	$bid=$_GET['boardid'];
	$row['boardid']=$bid;
	$result=mysql_query("select * from `photo` join `pin` using(photoid) where boardid='$bid'",$con); 
	$reresult=mysql_query("select * from `photo` join `pin` using(photoid) where `pinid` in( SELECT `pinid` FROM `repin` WHERE boardid='$bid')",$con); 
	}
	elseif(isset($_GET['likes']))
	{
	echo '<h3>Your Likes</h3>';
	$id=$_SESSION['user']['id'];
	$result=mysql_query("select * from `photolike` join `photo` using(`photoid`)  where userid=$id  order by liketime desc",$con); 
	}
	else
	{
	echo '<h3>Your Pins</h3>';
	$id=$_SESSION['user']['id'];
	$result =mysql_query("select * from `photo` join `pin` using(photoid) where boardid in (select boardid from board where userid='$id')",$con);
	$reresult =mysql_query("select * from `photo` join `pin` using(photoid)  where `pinid` in( SELECT `pinid` FROM `repin` WHERE boardid in (select boardid from board where userid='$id'))",$con); 
	}
	while($row=mysql_fetch_array($result))
	{ 
	$likebutton="SELECT * FROM  `photolike` WHERE userid=$uid and photoid=$row[photoid] limit 1";
			if (false == $likebutton) {
    echo mysql_error();
			}
	$return=mysql_query($likebutton,$con);
	$button=mysql_fetch_array($return);
	$count="select count(*) from photolike where photoid=$row[photoid]";
	$query=mysql_query($count,$con);
	$likecount=mysql_fetch_row($query);
	if($likecount[0]==0) $likecount[0]='likes (0)'; else $likecount[0]='likes ('.$likecount[0].')';

	if(!isset($_GET['likes']))
	{	$count="select count(*) from repin where pinid=$row[pinid]";
		$query=mysql_query($count,$con);
		$repincount=mysql_fetch_row($query);
		if($repincount[0]==0) $repincount[0]='repins (0)<br>'; else $repincount[0]='repins ('.$repincount[0].')<br>';
		$query=mysql_query("select * from comment where pinid=$row[pinid] and boardid=$row[boardid] order by commenttime limit 1",$con);
		$comment=mysql_fetch_array($query);
		if(empty($comment)) $comment['comment']=''; else $comment['comment']='comment : '.$comment['comment'].'<br>';
		if(!empty($button))
		{	$bid=$row['boardid'];
			$boarddetails=mysql_query("select * from board where boardid='$bid'",$con);
			$visibility=mysql_fetch_array($boarddetails);
			$uid=$_SESSION['user']['id'];
			if($visibility['userid']==$uid||$visibility['permission']=='0')
			{
				echo '<div class="block">'; 
				$commentbox='<input type="hidden" name="pinid" value="'.$row['pinid'].'"><input type="hidden" name="pinid" value="'.$row['boardid'].'"><img src="images/' . $row['path'] . '" width="200" height="200">';
				echo $row['title'].'<br><div class="show-image"><a href=likepin.php?photoid='.$row['photoid'].'&action=dislike><img src="images/dislikebutton.jpg" width="28" height="25" class="the-buttons"></a>&nbsp<a href=likepin.php?pinid='.$row['pinid'].'&action=delete><img src="images/deletebutton.jpg" width="25" height="25" class="the-buttons"></a><img src="images/' . $row['path'] . '" width="200" height="200"></div>'.$row['description'].'<br>'.$likecount[0].'<br>'.$repincount[0].$comment['comment'].'<a href="javascript:comment(\''. addslashes(htmlspecialchars($commentbox)) .'\')">comment</a>'; 
				echo '</div>'; 
			}
			else
			{
			$uid=$_SESSION['user']['id'];
			$id=$visibility['userid'];
			$check=mysql_query("select * from friend where ((user1id='$uid' AND user2id='$id') OR (user2id='$uid' AND user1id='$id')) AND status=1",$con);
				if(mysql_num_rows($check)>0)
				{
				echo '<div class="block">'; 
				$commentbox='<input type="hidden" name="pinid" value="'.$row['pinid'].'"><input type="hidden" name="pinid" value="'.$row['boardid'].'"><img src="images/' . $row['path'] . '" width="200" height="200">';
				echo $row['title'].'<br><div class="show-image"><a href=likepin.php?photoid='.$row['photoid'].'&action=dislike><img src="images/dislikebutton.jpg" width="28" height="25" class="the-buttons"></a>&nbsp<a href=likepin.php?pinid='.$row['pinid'].'&action=delete><img src="images/deletebutton.jpg" width="25" height="25" class="the-buttons"></a><img src="images/' . $row['path'] . '" width="200" height="200"></div>'.$row['description'].'<br>'.$likecount[0].'<br>'.$repincount[0].$comment['comment'].'<a href="javascript:comment(\''. addslashes(htmlspecialchars($commentbox)) .'\')">comment</a>'; 
				echo '</div>';
				}
				else
				{
				echo '<div class="block">'; 
				//$commentbox='<input type="hidden" name="pinid" value="'.$row['pinid'].'"><input type="hidden" name="pinid" value="'.$row['boardid'].'"><img src="images/' . $row['path'] . '" width="200" height="200">';
				echo $row['title'].'<br><div class="show-image"><a href=likepin.php?photoid='.$row['photoid'].'&action=dislike><img src="images/dislikebutton.jpg" width="28" height="25" class="the-buttons"></a>&nbsp<a href=likepin.php?pinid='.$row['pinid'].'&action=delete><img src="images/deletebutton.jpg" width="25" height="25" class="the-buttons"></a><img src="images/' . $row['path'] . '" width="200" height="200"></div>'.$row['description'].'<br>'.$likecount[0].'<br>'.$repincount[0].$comment['comment']; 
				echo '</div>';
				}
			}
		}
		else
		{	$bid=$row['boardid'];
			$boarddetails=mysql_query("select * from board where boardid='$bid'",$con);
			$visibility=mysql_fetch_array($boarddetails);
			$uid=$_SESSION['user']['id'];
			if($visibility['userid']==$uid||$visibility['permission']=='0')
			{
			echo '<div class="block">'; 
			$commentbox='<input type="hidden" name="pinid" value="'.$row['pinid'].'"><input type="hidden" name="boardid" value="'.$row['boardid'].'"><img src="images/' . $row['path'] . '" width="200" height="200">';
			echo $row['title'].'<br><div class="show-image"><a href=likepin.php?photoid='.$row['photoid'].'&action=like><img src="images/likebutton.jpg" width="25" height="25" class="the-buttons"></a>&nbsp<a href=likepin.php?pinid='.$row['pinid'].'&action=delete><img src="images/deletebutton.jpg" width="25" height="25" class="the-buttons"></a><img src="images/' . $row['path'] . '" width="200" height="200"></div>'.$row['description'].'<br>'.$likecount[0].'<br>'.$repincount[0].$comment['comment'].'<a href="javascript:comment(\''. addslashes(htmlspecialchars($commentbox)) .'\')">comment</a>'; 
			echo '</div>';
			}
			else
			{
			$uid=$_SESSION['user']['id'];
			$id=$visibility['userid'];
			$check=mysql_query("select * from friend where ((user1id='$uid' AND user2id='$id') OR (user2id='$uid' AND user1id='$id')) AND status=1",$con);
				if(mysql_num_rows($check)>0)
				{
				echo '<div class="block">'; 
				$commentbox='<input type="hidden" name="pinid" value="'.$row['pinid'].'"><input type="hidden" name="boardid" value="'.$row['boardid'].'"><img src="images/' . $row['path'] . '" width="200" height="200">';
				echo $row['title'].'<br><div class="show-image"><a href=likepin.php?photoid='.$row['photoid'].'&action=like><img src="images/likebutton.jpg" width="25" height="25" class="the-buttons"></a>&nbsp<a href=likepin.php?pinid='.$row['pinid'].'&action=delete><img src="images/deletebutton.jpg" width="25" height="25" class="the-buttons"></a><img src="images/' . $row['path'] . '" width="200" height="200"></div>'.$row['description'].'<br>'.$likecount[0].'<br>'.$repincount[0].$comment['comment'].'<a href="javascript:comment(\''. addslashes(htmlspecialchars($commentbox)) .'\')">comment</a>'; 
				echo '</div>';
				}
				else
				{
				echo '<div class="block">'; 
				$commentbox='<input type="hidden" name="pinid" value="'.$row['pinid'].'"><input type="hidden" name="boardid" value="'.$row['boardid'].'"><img src="images/' . $row['path'] . '" width="200" height="200">';
				echo $row['title'].'<br><div class="show-image"><a href=likepin.php?photoid='.$row['photoid'].'&action=like><img src="images/likebutton.jpg" width="25" height="25" class="the-buttons"></a>&nbsp<a href=likepin.php?pinid='.$row['pinid'].'&action=delete><img src="images/deletebutton.jpg" width="25" height="25" class="the-buttons"></a><img src="images/' . $row['path'] . '" width="200" height="200"></div>'.$row['description'].'<br>'.$likecount[0].'<br>'.$repincount[0].$comment['comment']; 
				echo '</div>'; 
				}
			}

		}
	}
	else
		if(!empty($button))
		{
		echo '<div class="block">'; 
		echo $row['title'].'<br><div class="show-image"><a href=likepin.php?photoid='.$row['photoid'].'&action=dislike><img src="images/dislikebutton.jpg" width="28" height="25" class="the-buttons"></a>&nbsp<img src="images/' . $row['path'] . '" width="200" height="200"></div>'.$row['description'].'<br>'.$likecount[0]; 
		echo '</div>';
		}
		else
		{
		echo '<div class="block">'; 
		echo $row['title'].'<br><div class="show-image"><a href=likepin.php?photoid='.$row['photoid'].'&action=like><img src="images/likebutton.jpg" width="25" height="25" class="the-buttons"></a>&nbsp<img src="images/' . $row['path'] . '" width="200" height="200"></div>'.$row['description'].'<br>'.$likecount[0]; 
		echo '</div>';
		}

} 
if(!isset($_GET['likes']))
{
while($row=mysql_fetch_array($reresult))
	{ 
	$count="select count(*) from photolike where photoid=$row[photoid]";
	$query=mysql_query($count,$con);
	$likecount=mysql_fetch_row($query);
	if($likecount[0]==0) $likecount[0]='likes (0)'; else $likecount[0]='likes ('.$likecount[0].')';
	$count="select count(*) from repin where pinid=$row[pinid]";
	$likebutton="SELECT * FROM  `photolike` WHERE userid=$uid and photoid=$row[photoid] limit 1";
			if (false == $likebutton) {
    echo mysql_error();
			}
	$return=mysql_query($likebutton,$con);
	$button=mysql_fetch_array($return);


	if(!isset($_GET['likes']))
	{
		if(!empty($button))
		{	if(isset($_GET['boardid']))
			$bid=$_GET['boardid'];
			else
			{
			$pinid=$row['pinid'];
			$pinboard=$row['boardid'];
			$boardid=mysql_query("select repin.boardid as reboardid from repin join pin using(pinid) where pinid=$pinid and pin.boardid=$pinboard",$con);
			$repinboard=mysql_fetch_array($boardid);
			$bid=$repinboard['reboardid'];
			}
			$boarddetails=mysql_query("select * from board where boardid='$bid'",$con);
			$visibility=mysql_fetch_array($boarddetails);
			$uid=$_SESSION['user']['id'];
			if($visibility['userid']==$uid||$visibility['permission']=='0')
			{
				echo '<div class="block">'; 
				$commentbox='<input type="hidden" name="pinid" value="'.$row['pinid'].'"><input type="hidden" name="pinid" value="'.$row['boardid'].'"><img src="images/' . $row['path'] . '" width="200" height="200">';
				echo $row['title'].'<br><div class="show-image"><a href=likepin.php?photoid='.$row['photoid'].'&action=dislike><img src="images/dislikebutton.jpg" width="28" height="25" class="the-buttons"></a>&nbsp<a href=likepin.php?pinid='.$row['pinid'].'&action=delete><img src="images/deletebutton.jpg" width="25" height="25" class="the-buttons"></a><img src="images/' . $row['path'] . '" width="200" height="200"></div>'.$row['description'].'<br>'.$likecount[0].'<br>'.$repincount[0].'<a href="javascript:comment(\''. addslashes(htmlspecialchars($commentbox)) .'\')">comment</a>'; 
				echo '</div>'; 
			}
			else
			{
			$uid=$_SESSION['user']['id'];
			$id=$visibility['userid'];
			$check=mysql_query("select * from friend where ((user1id='$uid' AND user2id='$id') OR (user2id='$uid' AND user1id='$id')) AND status=1",$con);
				if(mysql_num_rows($check)>0)
				{
				echo '<div class="block">'; 
				$commentbox='<input type="hidden" name="pinid" value="'.$row['pinid'].'"><input type="hidden" name="pinid" value="'.$row['boardid'].'"><img src="images/' . $row['path'] . '" width="200" height="200">';
				echo $row['title'].'<br><div class="show-image"><a href=likepin.php?photoid='.$row['photoid'].'&action=dislike><img src="images/dislikebutton.jpg" width="28" height="25" class="the-buttons"></a>&nbsp<a href=likepin.php?pinid='.$row['pinid'].'&action=delete><img src="images/deletebutton.jpg" width="25" height="25" class="the-buttons"></a><img src="images/' . $row['path'] . '" width="200" height="200"></div>'.$row['description'].'<br>'.$likecount[0].'<br>'.$repincount[0].'<a href="javascript:comment(\''. addslashes(htmlspecialchars($commentbox)) .'\')">comment</a>'; 
				echo '</div>';
				}
				else
				{
				echo '<div class="block">';
				//$commentbox='<input type="hidden" name="pinid" value="'.$row['pinid'].'"><input type="hidden" name="pinid" value="'.$row['boardid'].'"><img src="images/' . $row['path'] . '" width="200" height="200">';
				echo $row['title'].'<br><div class="show-image"><a href=likepin.php?photoid='.$row['photoid'].'&action=dislike><img src="images/dislikebutton.jpg" width="28" height="25" class="the-buttons"></a>&nbsp<a href=likepin.php?pinid='.$row['pinid'].'&action=delete><img src="images/deletebutton.jpg" width="25" height="25" class="the-buttons"></a><img src="images/' . $row['path'] . '" width="200" height="200"></div>'.$row['description'].'<br>'.$likecount[0].'<br>'.$repincount[0]; 
				echo '</div>';
				}
			}
		}
		else
		{	$bid=$row['boardid'];
			$boarddetails=mysql_query("select * from board where boardid='$bid'",$con);
			$visibility=mysql_fetch_array($boarddetails);
			$uid=$_SESSION['user']['id'];
			if($visibility['userid']==$uid||$visibility['permission']=='0')
			{
			echo '<div class="block">';
			$commentbox='<input type="hidden" name="pinid" value="'.$row['pinid'].'"><input type="hidden" name="boardid" value="'.$row['boardid'].'"><img src="images/' . $row['path'] . '" width="200" height="200">';
			echo $row['title'].'<br><div class="show-image"><a href=likepin.php?photoid='.$row['photoid'].'&action=like><img src="images/likebutton.jpg" width="25" height="25" class="the-buttons"></a>&nbsp<a href=likepin.php?pinid='.$row['pinid'].'&action=delete><img src="images/deletebutton.jpg" width="25" height="25" class="the-buttons"></a><img src="images/' . $row['path'] . '" width="200" height="200"></div>'.$row['description'].'<br>'.$likecount[0].'<br><a href="javascript:comment(\''. addslashes(htmlspecialchars($commentbox)) .'\')">comment</a>'; 
			echo '</div>';
			}
			else
			{
			$uid=$_SESSION['user']['id'];
			$id=$visibility['userid'];
			$check=mysql_query("select * from friend where ((user1id='$uid' AND user2id='$id') OR (user2id='$uid' AND user1id='$id')) AND status=1",$con);
				if(mysql_num_rows($check)>0)
				{
				echo '<div class="block">'; 
				$commentbox='<input type="hidden" name="pinid" value="'.$row['pinid'].'"><input type="hidden" name="boardid" value="'.$row['boardid'].'"><img src="images/' . $row['path'] . '" width="200" height="200">';
				echo $row['title'].'<br><div class="show-image"><a href=likepin.php?photoid='.$row['photoid'].'&action=like><img src="images/likebutton.jpg" width="25" height="25" class="the-buttons"></a>&nbsp<a href=likepin.php?pinid='.$row['pinid'].'&action=delete><img src="images/deletebutton.jpg" width="25" height="25" class="the-buttons"></a><img src="images/' . $row['path'] . '" width="200" height="200"></div>'.$row['description'].'<br>'.$likecount[0].'<br><a href="javascript:comment(\''. addslashes(htmlspecialchars($commentbox)) .'\')">comment</a>'; 
				echo '</div>';
				}
				else
				{
				echo '<div class="block">'; 
				$commentbox='<input type="hidden" name="pinid" value="'.$row['pinid'].'"><input type="hidden" name="boardid" value="'.$row['boardid'].'"><img src="images/' . $row['path'] . '" width="200" height="200">';
				echo $row['title'].'<br><div class="show-image">'.$likecount[0].'<a href=likepin.php?photoid='.$row['photoid'].'&action=like><img src="images/likebutton.jpg" width="25" height="25" class="the-buttons"></a>&nbsp<a href=likepin.php?pinid='.$row['pinid'].'&action=delete><img src="images/deletebutton.jpg" width="25" height="25" class="the-buttons"></a><img src="images/' . $row['path'] . '" width="200" height="200"></div>'.$row['description'].'<br>'.$likecount[0]; 
				echo '</div>'; 
				}
			}

		}
	}
	else
		if(!empty($button))
		{
		echo '<div class="block">'; 
		echo $row['title'].'<br><div class="show-image">'.$likecount[0].'<a href=likepin.php?photoid='.$row['photoid'].'&action=dislike><img src="images/dislikebutton.jpg" width="28" height="25" class="the-buttons"></a>&nbsp<img src="images/' . $row['path'] . '" width="200" height="200"></div>'.$row['description'].'<br>'.$likecount[0]; 
		echo '</div>';
		}
		else
		{
		echo '<div class="block">'; 
		echo $row['title'].'<br><div class="show-image">'.$likecount[0].'<a href=likepin.php?photoid='.$row['photoid'].'&action=like><img src="images/likebutton.jpg" width="25" height="25" class="the-buttons"></a>&nbsp<img src="images/' . $row['path'] . '" width="200" height="200"></div>'.$row['description'].'<br>'.$likecount[0]; 
		echo '</div>';
		}

}}?>	</div> 
</body>

			