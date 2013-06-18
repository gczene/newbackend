$(document).ready(function(){
	/* attached videos to case studies */
			if ($('#attachedVideos').length)
			{
				loadVideos();
			}

	
	if( $.fn.validate ) {
                $wzd_form = $( '.wzd-validate' ).validate({ onsubmit: false });
                $( '.wzd-validate' ).wizard({
                    buttonContainerClass: 'mws-button-row', 
                    onStepLeave: function(wizard, step) {
                        return $wzd_form.form();
                    }, 
                    onBeforeSubmit: function() {
                        return $wzd_form.form();
                    }
                });
	}
		
	if( $.fn.button ) {
		$(".mws-ui-button-radio").buttonset();
	}
	
    $('.ibutton').iButton();	
	
	if ($('.createMwsForm').length)
	{
		
		$('.createMwsForm').each(function(){
			$this = $(this);
			$form = $('FORM', $this);
			if ( $form.hasClass('mws-form') ){
				$form.addClass('mws-form');
			}

			$content = $form.html();
			$form.html('<div class="mws-form-inline">' + $content + '</div>'  );
			$('DIV.row', $form).addClass('mws-form-row').children('LABEL').addClass('mws-form-label');
			$('DIV.row', $form).children('input[type=text],textarea,select,span').wrap('<div class="mws-form-item"></div>');
			$('input[type=submit]', $form).wrap('<div class="mws-button-row" />').addClass('btn').addClass('btn-success');
			$('.niceCheckButton', $form).iButton();
		})
		
		
	}
	
	if ($('input[data-check-depenedency]').length){
		$('input[data-check-depenedency]').click(function(){
				$this = $(this);
				var _class = $this.attr('data-check-depenedency');
					if ($this.is(':checked')){
						$('.' + _class + '[value=' + $this.val() + ']').attr('checked', 'checked');
					}
		})
	}
	
	
	
	if ( $('table.trClick').length ){
		
		$('table.trClick tr td').live('click', function(){
			if (!$(this).hasClass('noClick') && $(this).parent('tr').attr('data-url') != undefined)
				window.location = $(this).parent('tr').attr('data-url');
		})
		
	}
	
	if ($('.mws-datatable-uniqe-fn').length)
	{
		$('.mws-datatable-uniqe-fn').each(function(){
			var orderBy = ( $(this).attr('data-order') == undefined ) ? 'ASC' : $(this).attr('data-order').toString().toLowerCase() ;
			var orderRow = ( $(this).attr('data-order-row') == undefined ) ?  0 : $(this).attr('data-order-row') ;
				$(this).dataTable({
					sPaginationType: "full_numbers"
				}).fnSort( [ [orderRow,orderBy] ] );;	
		})

	}
	
	
	if ( $('.paramEditor').length )
	{
		$('.paramEditor input').keyup(function(){
			$this = $(this);
			try{
				var obj = $.parseJSON( $('textarea[name="ModelPages[params_json]"]').val() );
			}
			catch(err){
				var obj = null;
			}
			if (!obj)
				obj = {};
			
//			return false;
			var _value = $this.val();
			var _key = $this.attr('name');
			if (_value != ''){
				obj[_key] = _value;
			}
			else{
				delete obj[_key];
			}
			$('textarea[name="ModelPages[params_json]"]').val( JSON.stringify(obj) );
			
		})
	}
	
	
	/* menu editing*/
	if ($('#placeList').length){
		$table = $('#placeList');
		$('.delete', $table).click(function(e){
			var id = $(this).closest('tr').attr('data-id');
			if (confirm('Delete ' + $(this).closest('tr').children('td').eq(0).text() + '?')){
				window.location = baseUrl + '/admin/menu_edit/deletePlace/' + id ;
			}
			return false;
		})
	}
	
	$('.datepicker').datepicker();
	$('.dateTimePicker').datetimepicker({dateFormat : 'yy-mm-dd'});
	
	if ($('#publishAssets').length)
	{
		$('#publishAssets a').click(function(){
			$.post( baseUrl + '/admin/publish_assets' , $('#publishAssets').serializeArray()  ,  function(data){
				alert( 'Ok' + data)
			})
		})
	}

/* delete lead image */
	$('.leadImagePreview button').click(function(){
		
		if (confirm('Are you sure?'))
		{
			$.post( document.location, {'deleteLeadImage' : $('img', $('.leadImagePreview')).attr('src'), YII_CSRF_TOKEN : $('input[name=YII_CSRF_TOKEN]').val()  }, function(data){
				var resp = $.parseJSON(data);
				if (resp.error){
					//oups some error occured!
					alert(resp.error);
				}
				else{
					
					$('.leadImagePreview').remove();
				}
			})
		}
		
		return false;
	})

})



var videos = new Array;

function renderVideos(){
	html = '';
		for (var x in videos ){
			html += '<a class="btn btn-danger delete" data-id="' + videos[x].id + '">Delete</a><textarea class="large" data-id="' + videos[x].id + '" >' + videos[x].lead + '</textarea>';
		}
	html += '<textarea class="large" data-id="0"></textarea>';
	html += '<a onclick="addVideo(true); return false;" class=btn>add another field</a>';
	$('#attachedVideos').html(html);
}
function loadVideos()
{
						$.post( baseUrl + '/admin/get_attached_videos', {id : $('#attachedVideos').attr('data-id'), YII_CSRF_TOKEN: $('input[name=YII_CSRF_TOKEN]').val() },function(data){
							var resp = $.parseJSON(data);
							for (var x in resp ){
								videos.push( {id: resp[x].id, lead : resp[x].lead })
							}
							renderVideos();
							$('a.delete' , $('#attachedVideos') ).live('click', function(){
								var $this = $(this);
								var id =  $(this).attr("data-id") ;
								if ( confirm('Delete this embedd video?') ){
									$this.next().remove();
									$this.remove();
									addVideo(true);
									console.log(videos)
								}

							})
							$('#attachedVideos textarea' ).live('keyup',function(){
								addVideo(false);
								console.log(videos)
							})
							$('#attachedVideos textarea' ).trigger('keyup');
						})

}

function addVideo(adding){
	videos = new Array();
	$('#attachedVideos textarea' ).each(function(){
		if ( $(this).val().replace(/ /g, '') != '' )
			videos.push( {id: $(this).attr('data-id'), lead: $(this).val()  })
	})
	if ($('#attachedVideos textarea' ).last().val() != '' && adding )
	{
		renderVideos()
	}
	
	$('#News__attachedVideos').val(JSON.stringify(videos));

	
}
