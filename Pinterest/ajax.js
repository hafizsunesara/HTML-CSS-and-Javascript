/* function validation()
{
  var email=document.getElementById("email").value;
  var password=document.getElementById("password").value;
  var repassword=document.getElementById("repassword").value;
if (email=="")
  {
  document.getElementById("emailalert").innerHTML="Enter username or password";
  } 
xmlhttp=new XMLHttpRequest();
xmlhttp.open("POST","createuser.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded"); 
xmlhttp.onreadystatechange=function()
  {

  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("emailalert").innerHTML=xmlhttp.responseText;
    }
  }
var v = "email="+email+"password="+password;
xmlhttp.send(v);
} */
function ajaxObj( meth, url ) {
	var x = new XMLHttpRequest();
	x.open( meth, url, true );
	x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	return x;
}
function ajaxReturn(x){
	if(x.readyState == 4 && x.status == 200){
	    return true;	
	}
}
