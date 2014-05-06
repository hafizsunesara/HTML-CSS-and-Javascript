<?php session_start();  $_SESSION['access']='true';include 'template.php'?><HTML>
<HEAD>
<link rel="stylesheet" type="text/css" href="design.css">
<script src="script.js"></script>
</HEAD>
<BODY>
<DIV class="signup">

<FORM name="form" action="createuser.php" method="post" >
	 <div id="alert"></div>
	 <h4>Sign Up</h4>
	 <hr/>
	<label>Email Id:</label><input type="email" id="email" name="email" ><br/>
	<label>Firstname:</label><input type="text" id="firstname" name="firstname"><br/>
	<label>lastname:</label><input type="text" id="lastname" name="lastname"><br/>
	<label>password:</label><input type="password" id="password" name="password" ><br/>
	<label>retype password:</label><input type="password" id="repassword" name="repassword"><br/>
	<label>sex:</label><select id = "sex" name="sex">
		<option value = "male">male</option>
		<option value = "female">female</option>
	</select><br/>
	<label>country:</label><select name="country" name="country">
		<option value="united states of america">United States</option>
		<option value="India">India</option>
		<option value="china">China</option>
		<option value="canada">Canada</option>
	</select><br/>
	<input type="submit" value="Sign up" class="submit" onsubmit="javascript:ajax_post()"><a href="signin.php">sign in</a>(already a member)
	
</FORM>
</DIV>
<?php include'footer.php'?>
<BODY>
</HTML>