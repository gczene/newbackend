<?php

class loginControl extends CFilter
{
  
    protected function preFilter($filterChain)
    {
        // logic being applied before the action is executed
	
	if ( Yii::app()->user->isGuest )
	{
		Yii::app()->user->returnUrl = Yii::app()->request->requestUri;
		Yii::app()->request->redirect( Yii::app()->baseUrl .   '/admin/login');
	}
	
        return true; // false if the action should not be executed
    }
 
	
    protected function postFilter($filterChain)
    {
        // logic being applied after the action is executed
    }    
    
}

