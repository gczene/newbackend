<?php 

/*
 * loading common static files 
 */

class coreScripts extends CFilter
{
    protected function preFilter($filterChain)
    {
        // logic being applied before the action is executed
		
		
	if (isset($_GET['assets']) || YII_DEBUG)
		$assetPath = Yii::app()->assetManager->publish( Yii::getPathOfAlias('backend.assets'), false, -1, true );
	else
		$assetPath = Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('backend.assets'));
	
		foreach($this->scriptFiles as $file)
			Yii::app()->clientScript->registerScriptFile( $assetPath . $file,0 );
		
		foreach($this->cssFiles as $file)
			Yii::app()->clientScript->registerCssFile( $assetPath . $file, 0 );
		
		Yii::app()->clientScript->registerScript( 'baseUrl', 'var baseUrl = "' . Yii::app()->baseUrl. '" ;' ,0 );
		return true; // false if the action should not be executed
		
	}
 
	protected function postFilter($filterChain)
	{
		// logic being applied after the action is executed
	}    
    
  
	
	protected function getCssFiles(){
		return array(
			'/css/admin.css',
		);
	}
	
	protected function getScriptFiles(){
		return array(
			'/admin/js/libs/jquery-1.8.3.min.js',
			'/admin/js/libs/jquery.mousewheel.min.js',
			'/admin/js/libs/jquery.placeholder.min.js',
			'/admin/custom-plugins/fileinput.js',
			'/admin/jui/js/jquery-ui-1.9.2.min.js',
			'/admin/jui/jquery-ui.custom.min.js',
			'/admin/jui/js/jquery.ui.touch-punch.js',
			'/admin/jui/js/timepicker/jquery-ui-timepicker.min.js',
			'/admin/plugins/datatables/jquery.dataTables.min.js',
			'/admin/plugins/flot/jquery.flot.min.js',
			'/admin/plugins/flot/plugins/jquery.flot.tooltip.min.js',
			'/admin/plugins/flot/plugins/jquery.flot.pie.min.js',
			'/admin/plugins/flot/plugins/jquery.flot.stack.min.js',
			'/admin/plugins/flot/plugins/jquery.flot.resize.min.js',
			'/admin/plugins/colorpicker/colorpicker-min.js',
			'/admin/plugins/validate/jquery.validate-min.js',
			'/admin/custom-plugins/wizard/wizard.min.js',
			'/admin/bootstrap/js/bootstrap.min.js',
			'/admin/js/core/mws.js',
			'/admin/js/demo/demo.dashboard.js',
			'/admin/js/demo/demo.table.js',
			'/admin/plugins/ibutton/jquery.ibutton.min.js',
			'/admin/js/admin.js',
		);		
	}
}

