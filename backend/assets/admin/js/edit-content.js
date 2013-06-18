
$(document).ready(function(){
	
	$('SELECT#type').change(function(){
		eval('editing.' + $(this).val() + '()' );
	}).trigger('change');
	
	
	$('#contentSubmit').click(function(){
		if(!window.JSON){
			alert('Browser does not support JSON object! Please use an uptodate browser!');
			return false;
		}
		$button	= $(this);
		$form	= $(this).closest('FORM');
		var type	= $( 'SELECT#type', $form ).val();
		if (type == 'LIST')
		{
			var params = new Array();
			$('#sortable LI').each(function(){
				
				var row = {
					type : $(this).attr('data-type'),
					id	: $(this).attr('data-id')
				}
				
				params.push(row);
			})
			$('input[name=params]').val( JSON.stringify(params) );
		}
		var postParams = $form.serializeArray();

		$.post(baseUrl + 'admin/edit_content/' + $('input[name=id]').val(), postParams, function(data){
			window.location= baseUrl + 'admin/contents';
		})
		
	})


})

var editing = {
	'LIST' : function(){
		this.hideRows('body');
		var postParams = {
			contentType : $('SELECT#type').val()
		}
		var params = $.parseJSON($('input[name=params]').val());
		
		
		$.post(document.location, postParams, function(data){
			$('.mws-form FIELDSET').append(data);
				$('[rel="popover"]').popover();

			$('#draggable>LI').draggable({
				  connectToSortable: "#sortable",
				  helper: "clone",
				revertDuration : 1000,
				  revert: "invalid"
			});
			 $( "#sortable" ).sortable({
				  revert: true
			});
			 $( "ul, li" ).disableSelection();
		})
		
	},
	CONTENT : function(){
		this.hideRows();	
	},
	EPG : function(){
		this.hideRows('body');
	},
	hideRows : function(){
		$('.mws-form-row').show();
		$('.additional').remove();
		for (var i = 0; i < arguments.length; i++)
		{
			var a = arguments[i];
			for (var i = 0 ; i < arguments.length; i++)
				$('[name=' + a + ']').closest('.mws-form-row').hide();
		}
		
	}
}

