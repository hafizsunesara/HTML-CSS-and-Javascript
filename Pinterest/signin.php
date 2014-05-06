<?php session_start(); $_SESSION['access']='true';include 'template.php'?><HTML>
<HEAD>
<link rel="stylesheet" type="text/css" href="design.css">

</HEAD>
<BODY>
<DIV class="signup">

<FORM name="form" action="login.php"  method="POST" >
	 <h4>Sign In</h4>
	 <hr/>
	 <DIV id="alert"></DIV>
	 <label>Email Id:</label><input type="email" id="email" name="email" ><br/>
	 <label>password:</label><input type="password" id="password" name="password"><br/>
	 <input type="submit" value="Sign in" class="submit" ><a href="signup.php">sign up</a>(new user)
</FORM>
</DIV>
<?php include'footer.php'?>
<BODY>
</HTML>
