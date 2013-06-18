var attached;
$(document).ready(function(){
			
			
	$('.connections').live('click', function(){
		
		attached = new attachedObj($(this).attr('data-id'), $('[data-rel=label]',  $(this).closest('tr')).text());
		
		
		$('.datepicker').datetimepicker({
			dateFormat : 'yy-mm-dd'
		});
		
		
	})
	
	$('.btn-success.add').live('click', function(){
		var $this = $(this),
		$tr = $this.closest('tr');
		attached.setConnection({
			contentId :  $tr.attr('data-id'),
			dateFrom : $('input.datepicker',  $tr).val()
		});
		
	})
	
	/* delete a connection*/	
	$('.icol-cancel.connection').live('click', function(data){
		attached.deleteConnection($(this));
		return false;
	})




	
})

var attachedObj = function(boxId, label){
	this.boxId = boxId;
	this.label = label;
	$('#boxTitle').text(this.label);
	$('.toggle').slideToggle();	
	
	this.currentAttached = function(){
		 $.jGrowl("Loading attached content list ", {
			position: "bottom-right"
		});

		$.post(baseUrl + 'admin/attached_contents', {'id' : this.boxId }, function(data){
			$('#attachedList').html(data);
			$(".datatablea").dataTable();
			$(".datatable-fn").dataTable({
				sPaginationType: "full_numbers"
			}).fnSort( [ [0,'desc'] ] );;			

//			$('#attachedList thead th').eq(0).trigger('click');
		

		})
	}
	
	
	this.deleteConnection = function($a){
		
		var label = $('.contentLabel', $a.closest('tr')).text();
		$('<div title="Confirm"></div>').append('body').html('Do you want to delete this connection?<br /><b>' + label + '</b>').dialog({
			modal: true,
			buttons : {
				Yes : function(){
					var postParams = {
						id : that.boxId,
						box_content_id : $a.attr('data-id'),
						'delete' : 1 
					}

					$.post(baseUrl + 'admin/attached_contents/alma', postParams, function(data){
						that.currentAttached();
					})
					$(this).dialog('close');
				},
				No : function(){
					$(this).dialog('close');
				}
			}
		})
		
	}
	
	this.setConnection = function(obj){
                $.jGrowl("Saving...", {
                    position: "bottom-right"
                });
		
		if (obj.contentId == undefined || obj.dateFrom == undefined){
			alert( ' content id or date from is not set properly in setConnection() method ' )
			return;
		}
		$.post(baseUrl + 'admin/attached_contents', {id : this.boxId, content_id: obj.contentId, date_from : obj.dateFrom }, function(data){
			that.currentAttached();	
		})
	}
	
	
	this.currentAttached();
	var that = this;
	
	
}
