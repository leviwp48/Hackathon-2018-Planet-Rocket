
$(document).ready(function(){
	if($("#hideme").hasClass("nextstate")){
		$("#view1").removeClass("visible").addClass("hidden");
		$("#register-form").removeClass("hidden").addClass("visible");
	}
});

$(document).ready(function(){
	if($("#hideme2").hasClass("nextstatelog")){
		$("#view1").removeClass("visible").addClass("hidden");
		$("#login-form").removeClass("hidden").addClass("visible");
	}
});


//navigate to organization options
$(function() {
    $("#org").click(function(){
        $("#view2").removeClass("hidden").addClass("visible");
        $("#view1").removeClass("visible").addClass("hidden");
    })
});


//navigate to org register form
$(function() {
    $("#org_reg").click(function(){
        $("#register-form").removeClass("hidden").addClass("visible");
        $("#view2").removeClass("visible").addClass("hidden");
    })
});

//navigate to login portion of site
/*$(function() {
    $("#org_login").click(function(){
        $("#login-form").removeClass("hidden").addClass("visible");
        $("#view2").removeClass("visible").addClass("hidden");
    })
}); 

this is an artifact form when the org login form and the org register form were on the same page

*/

//back button functionality
$(function() {
    $(".back").click(function(){
        $("#register-form").removeClass("visible").addClass("hidden");
        $("#login-form").removeClass("visible").addClass("hidden");
        $("#view2").removeClass("visible").addClass("hidden");
        $("#view1").removeClass("hidden").addClass("visible");
   		
   })
});

$(function(){
	$(".org_to_log").click(function(){
    	location.reload();
	})
});


