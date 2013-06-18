<?php

class WidgetContentList extends CWidget
{
	
	public $contents;
	public $page;
	
	public $assetPath;
	
	public $type;
	
	public $viewFile;
	
	public function init(){
		
		$this->assetPath = Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('backend.assets'));
		
		switch($this->type){
			case 'CONTENT' :
				$this->viewFile = 'view-content';
				break;
			default:
				$this->viewFile = 'view-list';
		}
		Yii::app()->clientScript->registerScriptFile( $this->assetPath . '/js/tinymce/jscripts/tiny_mce/jquery.tinymce.js' ,0);
		
	}
	
	
	public function run(){
		$this->render( $this->viewFile , array(
				'contents' => $this->contents,
				'assetPath'	=> $this->assetPath,
				'type'		=> $this->type,
				'page'	=> $this->page,
		));
	}
	
}