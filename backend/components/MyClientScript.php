<?php

class MyClientScript extends CClientScript
{
	
	/******************************************************************************
	 * for file uploading elfinder is integrated
	 * necessary files:
	 * backend.views.admin.elfinderBrowser.php called by actionElfinderBrowser method
	 ********************************************************************************/
	public function registerTinyMce()
	{
		$assetPath = Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('backend.assets'));	
			/* assets files */
			Yii::app()->clientScript->registerScriptFile( $assetPath . '/js/tinymce/jscripts/tiny_mce/tiny_mce.js' ,0 );
			Yii::app()->clientScript->registerScriptFile($assetPath . '/admin/plugins/elfinder2/js/elfinder.min.js');
			Yii::app()->clientScript->registerCssFile($assetPath . '/admin/plugins/elfinder2/css/elfinder.min.css');
			Yii::app()->clientScript->registerCssFile($assetPath . '/admin/plugins/elfinder2/css/theme.css');
		
		
			$this->registerScript('tiny', '
					$(function() {
					$("textarea.tinyMce").each(function(){
						var id = $(this).attr(\'id\');
							var ed = new tinyMCE.Editor(id, {
									// Location of TinyMCE script
									script_url : "' . $assetPath . '/js/tinymce/jscripts/tiny_mce/tiny_mce.js",

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
									content_css : "' . Yii::app()->theme->baseUrl . '/assets/css/editor-content.css",

									// Drop lists for link/image/media/template dialogs
									template_external_list_url : "lists/template_list.js",
									external_link_list_url : "lists/link_list.js",
//									external_image_list_url : "", // "' . Yii::app()->baseUrl . '/admin/image_list/" + pageId,
									media_external_list_url : "lists/media_list.js",
									height: "600px",
									// Replace values for the template plugin
									template_replace_values : {
											username : "Some User",
											staffid : "991234"
									},
                                    relative_urls: false,
									file_browser_callback : elfinderBrowser
							});
							ed.render();
						})

						function elfinderBrowser(field_name, url, type, win) {
							var elfinder_url = baseUrl +  \'/admin/elfinderBrowser?YII_CSRF_TOKEN=\' + $(\'input[name=YII_CSRF_TOKEN]\').val() ;    // use an absolute path!
							tinyMCE.activeEditor.windowManager.open({
								file: elfinder_url,
								title: \'elFinder 2.0\',
								width: 900,  
								height: 600,
								resizable: \'yes\',
								inline: \'yes\',    // This parameter only has an effect if you use the inlinepopups plugin!
								popup_css: false, // Disable TinyMCE\'s default popup CSS
								close_previous: \'no\'
								}, {
								window: win,
								input: field_name
							});
							return false;
						}

					});
			');
		
		
	}
	
}