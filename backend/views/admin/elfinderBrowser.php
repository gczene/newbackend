<!DOCTYPE html>
<html>
	<head>
		
<!-- jQuery-UI Stylesheet -->
<link rel="stylesheet" type="text/css" href="<?php echo $assetPath  ?>/admin/jui/css/jquery.ui.all.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $assetPath  ?>/admin/jui/jquery-ui.custom.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $assetPath  ?>/admin/jui/css/jquery.ui.timepicker.css" media="screen">
<script type="text/javascript" src="<?php echo $assetPath  ?>/admin/js/libs/jquery-1.8.3.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $assetPath  ?>/admin/plugins/elfinder2/css/elfinder.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $assetPath  ?>/admin/plugins/elfinder2/css/theme.css" />
<script type="text/javascript" src="<?php echo $assetPath  ?>/js/tinymce/jscripts/tiny_mce/tiny_mce_popup.js"></script>
<script type="text/javascript" src="<?php echo $assetPath  ?>/admin/jui/js/jquery-ui-1.9.2.min.js"></script>

<script type="text/javascript" src="<?php echo $assetPath  ?>/admin/plugins/elfinder2/js/elfinder.min.js"></script>


<script type="text/javascript">
  var FileBrowserDialogue = {
    init: function() {
      // Here goes your code for setting your custom things onLoad.
    },
    mySubmit: function (URL) {
      var win = tinyMCEPopup.getWindowArg('window');

      // pass selected file path to TinyMCE
      win.document.getElementById(tinyMCEPopup.getWindowArg('input')).value = URL;

      // are we an image browser?
      if (typeof(win.ImageDialog) != 'undefined') {
        // update image dimensions
        if (win.ImageDialog.getImageData) {
          win.ImageDialog.getImageData();
        }
        // update preview if necessary
        if (win.ImageDialog.showPreviewImage) {
          win.ImageDialog.showPreviewImage(URL);
        }
      }

      // close popup window
      tinyMCEPopup.close();
    }
  }

  tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);

			
  $(function() {
    var elf = $('#elfinder').elfinder({
      // set your elFinder options here
//      url: '<?php echo Yii::app()->baseUrl ?>/assets/elfinder/connectors/php/connector.php',  // connector URL
		url: '<?php echo Yii::app()->baseUrl ?>/admin/elfinderConnector',  // connector URL
		getfile : {
			onlyURL  : true,
			// allow to return multiple files info
			multiple : false,
			// allow to return filers info
			folders  : false,
			// action after callback (""/"close"/"destroy")
			oncomplete : function(){
				alert();
			}
		},	  
		getFileCallback: function(url) { // editor callback
			FileBrowserDialogue.mySubmit(url); // pass selected file path to TinyMCE 
		},
		customData : {
		    'YII_CSRF_TOKEN' : '<?php echo $token; ?>'
		}
//		  height: 1000
    }).elfinder('instance');      
  });
</script>
		
	</head>
	<body>
<?php 

?>		

<div id="elfinder">
	
</div>
		
			</body>
		
</html>


