
function _(x){
	return document.getElementById(x);
}
function toggleElement(x){
	var x = _(x);
	if(x.style.display == 'block'){
		x.style.display = 'none';
	}else{
		x.style.display = 'block';
	}
}

function ajax_post(){
    // Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
    // Create some variables we need to send to our PHP file
    var url = "createuser.php";
    var email = document.getElementById("email").value;
    var pass = document.getElementById("password").value;
	var repass=document.getElementById("repassword").value;
    var firstname = document.getElementById("firstname").value;
    var lastname = document.getElementById("lastname").value;
	var sex=document.getElementById("sex").value;
	var country=document.getElementById("country").value;
    var vars = "email="+email+"&passwprd="+pass+"&repassword="+repass+"&firstname="+firstname+"&lastname="+lastname+"&sex="+sex+"&country="+country;
    hr.open("POST", url, true);
    // Set content type header information for sending url encoded variables in the request
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			document.getElementById("alert").innerHTML = return_data;
	    }
    }
    // Send the data to PHP now... and wait for response to update the status div
    hr.send(vars); // Actually execute the request
    document.getElementById("status").innerHTML = "processing...";
}

var colCount = 0;
var colWidth = 0;
var margin = 40;
var windowWidth = 0;
var blocks = [];

$(function(){
	$(window).resize(setupBlocks);
});

function setupBlocks() {
	windowWidth = $(window).width();
	colWidth = $('.block').outerWidth();
	blocks = [];
	console.log(blocks);
	colCount = Math.floor(windowWidth/(colWidth+margin*1));
	for(var i=0;i<colCount;i++){
		blocks.push(margin);
	}
	positionBlocks();
}

function positionBlocks() {
	$('.block').each(function(){
		var min = Array.min(blocks);
		var index = $.inArray(min, blocks);
		var leftPos = margin+(index*(colWidth+margin));
		$(this).css({
			'left':leftPos+'px',
			'top':min+'px'
		});
		blocks[index] = min+$(this).outerHeight()+margin;
	});	
}

// Function to get the Min value in Array
Array.min = function(array) {
    return Math.min.apply(Math, array);
};
jQuery(function() {    
    jQuery(".the-buttons").hide();
    jQuery('.show-image').hover(function() {
         jQuery(this).find('.the-buttons').fadeIn(0);
    }, function() {
        jQuery(this).find('.the-buttons').fadeOut(0); 
    });
});

