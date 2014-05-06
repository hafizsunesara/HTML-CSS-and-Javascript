function checkusername(){
		var status = document.getElementById("plugin");
		var hr = new XMLHttpRequest();
		hr.open("GET", "http://localhost/pinterest/extension.php", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4 && hr.status == 200) {
				status.innerHTML = hr.responseText;
			}
		}
    hr.send();
	}
document.addEventListener('DOMContentLoaded', function() {
    checkusername();
});
