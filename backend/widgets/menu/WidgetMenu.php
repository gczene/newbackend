<?php


class WidgetMenu extends CWidget
{
	
	private $_places;
	
    public function init()
    {
        // this method is called by CController::beginWidget()
//		echo $this->controller->action->id; die();
    }
 
    public function run()
    {
		if (($this->_places = MenuPlaces::model()->notDeleted()->with('pages')->findAll()) || $this->controller->action->id == 'menu_edit' )
			$this->render('view-menu', array('places' => $this->_places) );
		else
			$this->controller->redirect( Yii::app()->createUrl('admin/menu_edit') );
	
    }
	
}