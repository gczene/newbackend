<?php

class RequirementCheckerController extends Controller
{
    
        public $layout = '';
		
	private $_config;	

	
	
	public function init(){
		parent::init();
		$this->_config = Yii::app()->getComponents(false);
	}
	/* file and directory list for checking */
        protected function getNecessaryFileList()
        {
            // file => writeable
            return array(
                'index.php' => false,
                'assets' => true,
                'assets/uploads' => true,
                'protected/runtime' => true,
            );
            
        }
		
	protected function getNecessaryConfig()
	{
		
		return array(
			
			'clientScript' => array(
				'class' => 'backend.components.MyClientScript',
			),
		);
		
	}


		


	public function actionIndex()
	{
            
		$c = $this->configCheck();
		
		foreach($this->necessaryConfig as $n){
			print_r($n);
			echo '<br />';
			print_r(array_diff(
					$c,$n
					));
		}
		
		die();
		$this->renderPartial('index', array(
                    'files' => $this->checkFiles(),
                ));
                
                
                
	}
	
	public function configCheck()
	{
		return $this->_config['clientScript'];
		
		
	}
	
	public function configExist($key, $value){
		if (is_string($value)){
			return isset($this->_config[$key]);
		}
		elseif( is_array($value)){
			
		}
		
		
	}
        

        
		
		
		
        
        private function checkFiles(){
            $output = array();
            foreach($this->necessaryFileList as $file => $writeableTest )
            {
                $output[] = array(
                    'file' => $file,
                    'ok'    => $this->_isOk($file, $writeableTest),
                ) ;
            }
            return $output;
            
        }
        
        private function _isOk($file, $writeableTest)
        {
            
            if (! file_exists($file) ){
                
                return array(
                    'status' => 'failed',
                    'reason' => 'Not exists!',
                );
                
            }
            elseif ($writeableTest && file_exists($file) && !is_writable($file) ){
                return array(
                    'status' => 'failed',
                    'reason' => 'Exists but Not writeable!',
                );
            }
            else{
                return array(
                    'status' => 'Ok',
                    'reason' => '',
                );
            }
        }
        
        
	public function beforeAction()
	{
		
		Yii::app()->setViewPath( Yii::getPathOfAlias('backend.views') );
		/* assetpath is generated ! used in the view file */

		return true;
	}

}