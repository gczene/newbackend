<script type="text/javascript">
        $(function() {
                $('textarea.tinymce').tinymce({
                        // Location of TinyMCE script
                        script_url : '<?php echo $assetPath ?>/js/tinymce/jscripts/tiny_mce/tiny_mce.js',

                        // General options
                        theme : "advanced",
                        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

                        // Theme options
                        theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
                        theme_advanced_toolbar_location : "top",
                        theme_advanced_toolbar_align : "left",
                        theme_advanced_statusbar_location : "bottom",
                        theme_advanced_resizing : false,

                        // Example content CSS (should be your site CSS)
                        content_css : "/css/content.css",

                        // Drop lists for link/image/media/template dialogs
                        template_external_list_url : "lists/template_list.js",
                        external_link_list_url : "lists/link_list.js",
                        external_image_list_url : "<?php echo Yii::app()->baseUrl ?>/admin/image_list/page_id/<?php echo $page->id ?>",
                        media_external_list_url : "lists/media_list.js",
			height: '600px',
                        // Replace values for the template plugin
                        template_replace_values : {
                                username : "Some User",
                                staffid : "991234"
                        }
                });
        });
		
		

function ajaxSave() {
    var ed = tinyMCE.get('content');
	
    // Do you ajax call here, window.setTimeout fakes ajax call
    ed.setProgressState(1); // Show progress
    window.setTimeout(function() {
        ed.setProgressState(0); // Hide progress
        alert(ed.getContent());
    }, 3000);
}		
</script>
<div id="container">
	<?php
		echo CHtml::fileField('','', array(
			'class' => 'contentImageUpload', 
			'data-url' => Yii::app()->createUrl('/admin/content_image_upload/'),
			'data-form-data' => json_encode(array(
				'page_id'		=> $page->id,
				'content_id'	=> '',
				'type'			=> 'content_image',

			)),
		)); 
	?>
	
		<?php if (count($contents)): ?>
			<?php foreach($contents as $content): ?>
			<form data-id="<?php echo $content->id  ?>">
				
				<?php 
					echo CHtml::hiddenField('content_id', $content->id);
					echo CHtml::hiddenField('page_id', $page->id );
				?>
				<textarea class="tinymce" name="Content[content]"><?php echo $content->content; ?></textarea>
			</form>
			<?php endforeach; ?>
		<?php else: ?>
			<form>
				<?php 
					echo CHtml::hiddenField('content_id', 0);
					echo CHtml::hiddenField('page_id', $page->id );
					echo CHtml::textarea('Content[content]', '', array( 'class' => 'tinymce' ) );
				?>
				
			</form>
		<?php endif; ?>
		<input type="button" id="contentSave" value="Update" />
</div>
