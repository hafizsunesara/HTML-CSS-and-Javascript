<?php
session_start();
include 'database.php';
if(isset($_SESSION['user']['id']))
{
	$uid=$_SESSION['user']['id'];
	$string = '<h4>Pin Your URL</h4><form name="urlplugin" method="post" action="http://localhost/Pinterest/plugin_pin.php"><input type="text" name="url" id="url" size="50" placeholder="URL...."><br><input type="text" name="title" id="title" size="50" placeholder="Title...."><br>';
    $result = mysql_query("select * from board where userid='$uid'",$con);
	$string .="<select name='board'>";
	while ($row = mysql_fetch_assoc($result)) {
				unset($id, $name);
                  $id = $row['boardid'];
                  $name = $row['boardname']; 
                  $string .= '<option value="'.$id.'">'.$name.'</option>';

	}
	$string .= "</select></br>";
	$string .='<input type="text" name="description" id="description" size="50" placeholder="description...."><br><input type="tag" name="tag" id="tag" size="50" placeholder="tag...."><br><input type="submit" value="pinit"></form>';
	echo $string;
	exit();
}
else
{
echo '<h3>Please Login</h3>';
exit();
}	
?>