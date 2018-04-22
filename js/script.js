/*
**Created :Venkatesh J
**Date : 21-07-2017
**Detail : javascript for the website
*/
//for maps plugin
$(document).ready(function(){
    $("#check_submit").click(function(){
  	var value_url = "result.php?url=" + $('#url').val();
        $("#div1").load(value_url);
    });
});


//for ajax sql query
function sql_url() {
var url_name = document.getElementById("sql_urlval").value;	
// Returns successful data submission message when the entered information is stored in database.
var dataString = 'url_name=' + url_name;
if (url_name == '') {
alert("Please Fill All Fields");
} else {
// AJAX code to submit form.
$.ajax({
type: "POST",
url: "ajaxjs.php",
data: dataString,
cache: false,
success: function(html) {
alert(html);
}
});
}
return false;
}

//functin for nav bar
$(function () {	    
    $('.navbar-toggler').on('click', function(event) {
		event.preventDefault();
		$(this).closest('.navbar-minimal').toggleClass('open');
	})
});
