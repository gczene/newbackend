<?php

 
 return array(
	'controllerMap'=>array(
            'admin'                 => 'webroot.backend.controllers.AdminController',
            'requirementChecker'    => 'webroot.backend.controllers.RequirementCheckerController',
	),	
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'webroot.backend.controllers.*',
		'backend.filters.*',
		'backend.models.*',
		'backend.components.*',
        'ext.feed.*',
	),
	// application components
	'components'=>array(
		'encrypt' => array(
			'class' => 'Encrypt',
		),
		'file'=>array(
			'class'=>'backend.extensions.file.CFile',
		),		
		'cache'=>array(
		    'class'=>'CApcCache',
		),
		'request'=>array(
            'class' => 'backend.components.HttpRequest',
		    'enableCsrfValidation'=>true,
            'noCsrfValidationRoutes' => array('register_email', 'frontend/register_email'),
		),	    
		'enum' => array(
			'class' => 'backend.components.Enum',
		),		
		'clientScript' => array(
			'class' => 'backend.components.MyClientScript',
		),
		'vod' => array(
			'class' => 'backend.components.Vod',
		),
		'email' => array(
			'class' => 'backend.components.Email',
		),
		'CURL' =>array(
			'class' => 'backend.extensions.curl.Curl',
			 //you can setup timeout,http_login,proxy,proxylogin,cookie, and setOPTIONS
		 ),
		'Xml' =>array(
			'class' => 'backend.components.Xml',
			 //you can setup timeout,http_login,proxy,proxylogin,cookie, and setOPTIONS
		 ),
        'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,			
//			'rules'=>array(
//				'<controller:(requirementChecker|admin|gii)>' => '<controller>',
//				'<controller:(requirementChecker|admin|gii)>/<action:\w+>' => '<controller>/<action>',
//				'<controller:admin>/<action:backgrounds>/<page_id:\d+>' => '<controller>/<action>',
//				'<controller:contactEmail>' => 'frontend/contactEmail' ,
//				'<controller:(requirementChecker|admin|gii)>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
//				'<action:(register_email|feed)>' => 'frontend/<action>',
//				'<url:([\w-])*>'		=> 'frontend/index',
//				'<url:([\w-])*>/<listBy:([\w-])+>'		=> 'frontend/index',
//				'<url:([\w-])*>/<id:\d+>/<label:.+>'		=> 'frontend/index',
//				
//			),
         )
    )     
     
 );