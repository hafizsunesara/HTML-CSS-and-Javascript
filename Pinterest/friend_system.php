<?php
session_start();
require_once('database.php');
if (isset($_POST['type']) && isset($_POST['user'])){
	$user = preg_replace('#[^a-z0-9]#i', '', $_POST['user']);
	if($_POST['type'] == "friend"){
		$loggeduser=$_SESSION['user']['id'];
		$sql = "SELECT COUNT(*) FROM friend WHERE user1id='$user' AND status='1' OR user2id='$user' AND status='1'";
		$query = mysql_query($sql,$con);
		$friend_count = mysql_fetch_row($query);
		$sql = "SELECT COUNT(*) FROM friend WHERE user1id='$loggeduser' AND user2id='$user' AND status='1' LIMIT 1";
		$query = mysql_query($sql,$con);
		$row_count1 = mysql_fetch_row($query);
		$sql = "SELECT COUNT(*) FROM friend WHERE user1id='$user' AND user2id='$loggeduser' AND status='1' LIMIT 1";
		$query = mysql_query($sql,$con);
		$row_count2 = mysql_fetch_row($query);
		$sql = "SELECT COUNT(*) FROM friend WHERE user1id='$loggeduser' AND user2id='$user' AND status='0' LIMIT 1";
		$query = mysql_query($sql,$con);
		$row_count3 = mysql_fetch_row($query);
		$sql = "SELECT COUNT(*) FROM friend WHERE user1id='$user' AND user2id='$loggeduser' AND status='0' LIMIT 1";
		$query = mysql_query($sql,$con);
		$row_count4 = mysql_fetch_row($query);
	    if($friend_count[0] > 99){
            echo "$user currently has the maximum number of friends, and cannot accept more.";
	        exit();
        } else if ($row_count1[0] > 0 || $row_count2[0] > 0) {
	        echo "You are already friends with $user.";
	        exit();
	    } else if ($row_count3[0] > 0) {
	        echo "You have a pending friend request already sent to $user.";
	        exit();
	    } else if ($row_count4[0] > 0) {
	        echo "$user has requested to friend with you first. Check your friend requests.";
	        exit();
	    } else {
	        $sql = "INSERT INTO friends(user1, user2, datemade) VALUES('$loggeduser','$user',now())";
		    $query = mysql_query($sql,$con);
	        echo "friend_request_sent";
	        exit();
		}
	} else if($_POST['type'] == "unfriend"){
		$sql = "SELECT COUNT(*) FROM friend WHERE user1id='$loggeduser' AND user2id='$user' AND status='1' LIMIT 1";
		$query = mysql_query($sql,$con);
		$row_count1 = mysql_fetch_row($query);
		$sql = "SELECT COUNT(*) FROM friend WHERE user1id='$user' AND user2id='$loggeduser' AND status='1' LIMIT 1";
		$query = mysql_query($sql,$con);
		$row_count2 = mysql_fetch_row($query);
	    if ($row_count1[0] > 0) {
	        $sql = "DELETE FROM friend WHERE user1id='$loggeduser' AND user2id='$user' AND status='1' LIMIT 1";
			$query = mysql_query($sql,$con);
	        echo "unfriend_ok";
	        exit();
	    } else if ($row_count2[0] > 0) {
			$sql = "DELETE FROM friend WHERE user1id='$user' AND user2id='$loggeduser' AND status='1' LIMIT 1";
			$query = mysql_query($sql,$con);
	        echo "unfriend_ok";
	        exit();
	    } else {
	        echo "No friendship could be found between your account and $user, therefore we cannot unfriend you.";
	        exit();
		}
	}
}
?>
