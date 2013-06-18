$(document).ready(function(){
	$('.editRecord').live('click', function(){
		$a = $(this);
		var id = $a.attr('data-id');
		if (id == undefined){
			alert('No id defined for this item!');
		}
		else{
			var params = {
				page_id		: pageId,
				content_id		: id
			};
			$.colorbox({
				href : baseUrl + '/admin/content_form',
				data: params,
				onComplete : function(){
					$('.contentForm #save').click(function(){
						var params = $(this).closest('FORM').serializeArray();
						$.post($(this).closest('FORM').attr('action'), params, function(data){
							var resp = $.parseJSON(data);
							if (id > 0)
							$('a[data-id=' + id + ']').text(resp.label);
							else{
								$('.contentList').prepend('<li><a href="#" class="editRecord" data-id="' + resp.id + '">' + resp.label + '</li></a>');
							}
							$.colorbox.close();
						})
					})
				}
			});

		}
		return false;
	})
	
	
	$('.imageUpload').live('click', function(){
		var rel = $(this).attr('rel');
		var place = $('#' + rel ) ;
		$(this).fileupload({
			'dataType' : 'json',
			'done'	: function(e,data){
						if (data.result.error){
							alert( data.result.errorMsg );
						}
						else{
//							alert(rel.substr( 3, rel.length ));
							$('#' + rel.substr( 3, rel.length ) ).val(data.result.url);
							place.attr('src', data.result.url).load(function(){
								$.colorbox.resize();
							})
						}					
			}
		})

	})

	$('.icon.delete').live('click', function(data){
		var id = $(this).closest('DIV').attr('data-id');
		var $this = $(this);
		if (confirm('Are you delete this content?') ){
			$.post( baseUrl + '/admin/delete_content', {id : id}, function(data){
				$this.closest('LI').remove();
				createPager();
			})
			
		}
	})


if ( $('.contentList').length ){
	createPager();
}

	//saving at pages type = content
	$('#contentSave').click(function(){
		var container = $(this).closest('#container');
		var contents = new Array();
		var counter = $('.tinymce', container).length;
		var n = 0;
		$('.tinymce', container).each(function(){
		
			$form = $(this).closest('FORM');
			var params = $form.serializeArray();
			
			$.post(baseUrl + '/admin/content_form', params, function(data){
				showDone();
			})
			n++;
		})
		
	})


	/* content image uploading */
	$('.contentImageUpload').click(function(){
		$(this).fileupload({
			'dataType' : 'json',
			'done'	: function(e,data){
						if (data.result.error){
							alert( data.result.errorMsg );
						}
						else{
//							alert(rel.substr( 3, rel.length ));

						}					
			}
		})

	})


})

/* box to indicate everything went well at saving */
function showDone(){
	$('BODY').prepend('<div class="middleMsg all-rounded-10px">Done!</div>');
	setTimeout( function(){
		$('.middleMsg').remove();
		if ( $('input[name=content_id]').val() == 0 ){
			window.location.reload()
		}
		
	}, 2000 );
	
//	$('BODY').hide();
	
}

function createPager(){
	
}

