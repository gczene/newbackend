<?php

class AdminController extends Controller
{
    
//    public $layout = '2cols';
	
	public $apps;
	
	public $assetPath;

	public  $layout= 'layout-admin';
	
	public $theme;
	
	public function beforeAction()
	{
		
		Yii::app()->setViewPath( Yii::getPathOfAlias('backend.views') );
		Yii::app()->theme = 'corporate';
		/* assetpath is generated ! used in the view file */
		$this->assetPath = Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('backend.assets'));

		return true;
	}
	
    
	public function actionIndex()
	{
		
		$data = array();
		$this->render('index', $data);
		
	}

	
	
	public function actionUsers()
	{
		$this->render('viewUsers', array(
			'users' => Users::model()->findAll(),
		));
	}
	
	public function actionUser_form()
	{
		if ( !isset($_GET['id']))
			throw new CHttpException('404', 'User id not defined');
		
		$userId = (int) $_GET['id'];
		
		if ($user = $userId ? Users::model()->findByPk($userId) : new Users){
			
			
			$form = new CForm($user->crudConfig, $user );
			
			if ($form->submitted('addUser') && $form->validate()){
				$form->model->save();
				$this->redirect( $this->createUrl('admin/users') );
			}
			
			$this->render('viewUserForm', array('form' => $form));
		}
		
	}
	
	public function actionMenu_edit()
	{
		
		if (isset( $_GET['deletePlace'] )){
			MenuPlaces::model()->deleteByPk( Yii::app()->encrypt->decode( $_GET['deletePlace'] ) );
			
		}
		
		$placeId	= isset($_GET['place_id']) ? (int) $_GET['place_id'] : 0;
		$place		= ($placeId) ? MenuPlaces::model()->findByPk($placeId) : new MenuPlaces;
		
		$id			= (isset($_GET['id'])) ? (int) $_GET['id'] : 0;
		$model		= ($id) ? ModelPages::model()->findByPk($id) : new ModelPages;

		$pages		= ModelPages::model()->findAll();
				
		$form = new CForm($model->crudConfig(), $model );
		
		if ($form->submitted('registerPage') && $form->validate()){
			$model->attributes = $_POST['ModelPages'];
			if (!$model->save()){
				// error handling here...
			}
			else{
				$this->redirect( Yii::app()->request->requestUri );				
			}
			
		}

		$placeForm = new CForm($place->crudConfig(), $place);
		
		
		if ($placeForm->submitted('registerPlace')&& $placeForm->validate()){
			$place->attributes = $_POST['MenuPlaces'];
			$place->save();
			$this->redirect( Yii::app()->baseUrl . '/admin/menu_edit' );
		}
		
		$this->render('view-menu-edit', array(
			'pages'			=> $pages,
			'form'			=> $form,
			'model'			=> $model,
			'places'		=> MenuPlaces::model()->findAll(),
			'placeForm'		=> $placeForm,
		));
	}
	
	

	public function actionDelete_content(){
		if (isset($_POST['id']) && Yii::app()->request->isAjaxRequest){
			$id = (int) $_POST['id'];
			if ($content = Contents::model()->findByPk($id))
			{
				$content->status = 2;
				$content->save();
			}
		}
	}
	
	
	
	public function actionNewsletter()
	{
		RegisteredEmails::downloadCSV();
				
	}
    
    
    public function actionYoutubeCSV()
    {
        OurNetwork::downloadCSV();
    }
	
	
	public function actionImage_list(){
		if (isset($_GET['page_id'])){
			$dir = Yii::getPathOfAlias('webroot.images.uploads.' . $_GET['page_id']);
//			$files = CFileHelper
			echo $dir;
		}
	}
	
	
	
	/*
	 * get the content list of a page (it lists the defined main contents not the additional contents)
	 */
	public function actionPage()
	{

		$pageId = (int) $_GET['id'];
		if ($page = ModelPages::model()->with('contents:notAttachedVideo')->findByPk($pageId) ){
//			$page->setParam('children', 3);
			$this->pageTitle = 'Contents ' . $page->label;
			
			$this->render('view-page', array(
				'page' => $page,
			));
			
		}
		else
			throw new CHttpException('Page id is not correct');
		
	}
	
	
	
	public function actionElfinderBrowser()
	{
		$assetPath = Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('backend.assets'));	
		$this->renderPartial('elfinderBrowser', array(
			'assetPath' => $assetPath,
			'token'	    => isset($_GET['YII_CSRF_TOKEN']) ? $_GET['YII_CSRF_TOKEN'] : null,
		));
	}
	
	public function actionElfinderConnector(){
		Yii::import('backend.extensions.elfinder.*');
		$opts = array(
			// 'debug' => true,
			'roots' => array(
				array(
					'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
					'path'          => Yii::getPathOfAlias('webroot.assets.uploads'),         // path to files (REQUIRED)
					'URL'           => Yii::app()->baseUrl . '/assets/uploads/', // URL to files (REQUIRED)
					'accessControl' => 'access'             // disable and hide dot starting files (OPTIONAL)
				)
			)
		);

		// run elFinder
		$connector = new elFinderConnector(new elFinder($opts));
		$connector->run();
		
	}
	
	
	/*
	 * edit all contents: news. content and other types as well
	 */
	public function actionEdit_content()
	{
		$pageId = (int)$_GET['page_id'];
		$contentId = (isset($_GET['content_id'])) ? (int)$_GET['content_id'] : 0;
		$internalId = (isset($_GET['internal_id'])) ? $_GET['internal_id'] : NULL; // if page has fixContent param
		
		
		
		if ($page = ModelPages::model()->together('contents')->findByPk($pageId))
		{
			$className = $page->contentClassName; // see page::getContentClassName() method
			if ( $model = Contents::editable($className,$contentId) ){
					$parent = $model;
					if ($model->hasPreview())
						$model = Contents::model()->findByAttributes(array('is_preview' => 1, 'parent_id' => $model->id));
					
                    
                    /* deleting lead image */
                    if(isset($_POST['deleteLeadImage']) && Yii::app()->request->isAjaxRequest ){
                        echo json_encode($model->deleteLeadImage($_POST['deleteLeadImage']));
                        Yii::app()->end();
                    }
                    
                    
					Yii::app()->clientScript->registerScriptFile( $this->assetPath . '/js/tinymce/jscripts/tiny_mce/jquery.tinymce.js' ,0);				
					$this->pageTitle = (($contentId) ? 'Edit ' . $model->label : 'Add new item to ' . $page->label) . ($internalId ? ' - ' . $internalId  : '') ;
				
					
					/*create or update a content*/
					if (isset($_POST[$className]['lead_image']) && $_POST[$className]['lead_image'] == '')
						unset($_POST[$className]['lead_image']);
					if (isset($_POST[$className]['hover_lead_image']) && $_POST[$className]['hover_lead_image'] == '')
						unset($_POST[$className]['hover_lead_image']);
					
                                        

					/* these fields must be filled manually! */
					$model->page_id = $pageId;
					$model->internal_id = $internalId;
					
					/* javascript also needs the page id , register it into <head>*/
					YIi::app()->clientScript->registerScript('pageId', 'var pageId = ' . $pageId . ';', 0 );

					/* creating form from the model. TO change the form see crudConfig() method in all model which extended from Contents parent model class  */
					$form = new CForm($model->crudConfig, $model );
					if ($form->submitted('save') && $form->validate()){
							if ($model->is_preview && $model->parent_id ){
								// if it is a preview
								$parent->attributes = $parent->copyAttributes($model->attributes);
								if ($parent->save()){
									$model->delete();
									
									$this->redirect( (isset($_GET['referer']) ? Yii::app()->encrypt->decode($_GET['referer']) : $this->createUrl('admin/page', array('id'=>$page->id)) ));
								}
								else
									$form->model->addError('label', 'Error while saving data!');
							}
							elseif( $model->is_preview && !$model->parent_id ){
								$model->is_preview = 0;
								$model->status = 1;
								if ($model->save()){
									$this->redirect( (isset($_GET['referer']) ? Yii::app()->encrypt->decode($_GET['referer']) : $this->createUrl('admin/page', array('id'=>$page->id)) ));
								}
								else
									$form->model->addError('label', 'Error while saving data!');
							}
							else{
								if ($model->save()){
									$this->redirect( (isset($_GET['referer']) ? Yii::app()->encrypt->decode($_GET['referer']) : $this->createUrl('admin/page', array('id'=>$page->id)) ));
								}
								else
									$form->model->addError('label', 'Error while saving data!');
							}
					}
					if ($form->submitted('tempSave') && $form->validate()){
						if ($model->parent_id || ( ! $model->parent_id && $model->is_preview ) ){
							$preview = $model;
						}
						else{
							$preview = new $className;
						}
						$preview->attributes	= $form->model->attributes;
						$preview->is_preview	= 1;
						$preview->status		= 2; //logical delete to hide from other visitors
						if (! $model->is_preview)
							$preview->parent_id		= $parent->id;
						
						if ($preview->save()){
							if (isset($_GET['referer']))
								$this->redirect(  Yii::app()->encrypt->decode($_GET['referer']) );
							else
								$this->redirect( $this->createUrl('admin/page', array('id' => $preview->page_id )));
						}
						else
							$form->model->addError('label', 'Error while saving data!');
					}
					
					$form->showErrorSummary = true;
					$this->render('view-contents', array(
						'page'	=> $page,
						'form'		=> $form,
						'internalId' => $internalId,
					));
			}
			else{
				throw new CHttpException('this content does not exist!');
			}
			
		}
		else
			throw new CHttpException('This page does not exist!');
		
		
	}
	
	
	
	
	
	
	public function actionLogin()
	{
		$this->layout = 'layout-admin-login';
		
	    if (isset($_POST['Login']))
	    {
		$identity = new AdminUserIdentity( $_POST['Login']['email'], $_POST['Login']['password'] );
		
		if($identity->authenticate()){
			$response = array('error'	    => 0);  
			Yii::app()->user->login($identity);
		}
		else{
			$response = array('error'	    => 1);  
		}
		
		$response['errorMessage']	= $identity->errorMessage;
		$response['returnUrl']		= Yii::app()->baseUrl  . '/admin';
		
		
		
		Yii::app()->request->redirect( Yii::app()->user->returnUrl);
		Yii::app()->end();
	    }
		if ( !preg_match('/admin/', Yii::app()->user->returnUrl ) )
			Yii::app()->user->returnUrl = Yii::app()->createUrl('admin');
		
	    Yii::app()->clientScript->registerScriptFile( $this->assetPath . '/js/admin/login.js'  );
	    $this->render('view-login');
	    
	}
	
	
	public function actionFlush()
	{
		Yii::app()->cache->flush();
	}
	
	
	public function actionLogout()
	{
	    Yii::app()->user->logout();
	    Yii::app()->request->redirect( Yii::app()->baseUrl . '/admin'  );
	}
	
	public function filters()
	{
		return array(
			array(
				'loginControl - login' ,
				'class'=>'loginControl',
			),
			//loading common scripts into all actions
			array( 
				'coreScripts',
				'class' => 'coreScripts',
			),
		    
		);
	}

	
	public function actionSeo(){
		
		$model = new ModelPages();
		$pages = $model->sitePages;
		
		$this->render('viewSeo', array(
			'pages' => $pages,
		));
	}
	
	public function actionSeo_edit()
	{
		if ( $page = ModelPages::model()->findByPk($_GET['page_id']) ){
			
			$form = new CForm($page->seoForm(), $page );
			
			if ($form->submitted('registerPage') && $form->validate())
			{
				$form->model->save();
				$this->redirect( (isset($_GET['referer'])) ? Yii::app()->encrypt->decode($_GET['referer']) :$this->createUrl('admin/seo')   );
			}
			
			$this->render('viewSeoEdit', array(
				'page' => $page,
				'form' => $form,
			));
			
		}
	}
		

	public function actionBackgrounds()
	{
		
		$pageId = (isset($_GET['page_id']) && is_numeric( Yii::app()->encrypt->decode( $_GET['page_id'] ))) ? Yii::app()->encrypt->decode($_GET['page_id']) : null; 
		
		if ($pageId){
			
			$page = ModelPages::model()->findByPk($pageId);
			$form = new CForm($page->bgFormConfig(), $page );

			if ($form->submitted('registerPage') && $form->validate()){
				$form->model->save();
				$this->redirect( 
						(isset($_GET['referer']) ? Yii::app()->encrypt->decode($_GET['referer']) : Yii::app()->createUrl('admin/backgrounds') )
						);
			}
			$data = array(
				'form' => $form,
				'page' => $page,
			);
		}
		else{
			$data = array('pages' => ModelPages::model()->sitePages);
		}
		$this->render('viewBackgrounds', $data);
		
	}
	
	public function actionPublish_assets()
	{
		$this->_publish(array(
			'application',
			'backend',
		));
		
	}
	
	private function _publish( array $startDirs)
	{
		
		foreach($startDirs as $startDir){
			$dir = Yii::app()->file->set($startDir);
			foreach($dir->getContents(true) as $file){
				if (is_dir($file)){
					$dirname = substr( $file,  strrpos($file, '/') + 1 );
					if ($dirname == 'assets'){
						$assetPath = Yii::app()->assetManager->publish( $file,  false, -1, true );
						echo $file . PHP_EOL;
					}
				}
			}
		}
		
	}
	
	
	
	public function actionGet_attached_videos()
	{
		if (isset($_POST['id']) && Yii::app()->request->isAjaxRequest  )
		{
			$id = $_POST['id'];
			
			if ($content = Contents::model()->findByPk($id) )
			{
				$out = array();
				foreach($content->attachedVideos() as $video){
					$out[] = $video->attributes;
				}
				echo  json_encode($out);
			}
			else{
				return null;
			}
			
		}
	}
	
}