
$(document).ready(function(){
	
	$('body').css('background', '#efefef');
	
	
	
	var f = $('#loginBox'); // f = form
	
	
	/* triggering ENTER key  */
	$('input[type=text],input[type=password]', f).keyup(function(e){
	    if(e.keyCode == 13 &&  $('input[type=text]', f).val() != '' && $('input[type=password]', f).val() != ''  ){
		$('input[type=button]', f).trigger('click');
	    }
	})
	
	
	/* submit login form */
	$('input[type=button]', f).click(function(){

	    var postParams = $('#loginBox').serializeArray();
	    $.post( document.location, postParams, function(data){
		var resp = $.parseJSON(data);
		if (resp.error){
		    $('#errorMessage', f).html(resp.errorMessage);
		     f.effect("shake", { times:2 }, 300);
		}
		else
		    document.location = resp.returnUrl ;
	    } )
	    
	})
	
})
