<?php

define( 'ENVIRONMENT', apache_getenv('ENVIRONMENT') );

if (ENVIRONMENT == 'dev'){
    define('PROJECT', 'newBackend');

    $cacheKey = PROJECT . ENVIRONMENT ;

    // change the following paths if necessary
    $yii=dirname(__FILE__).'/../yii-core/yii.php';
    require_once($yii);
     Yii::setPathOfAlias('backend', dirname(__FILE__) . '/backend/' );
    

    $config=dirname(__FILE__).'/protected/config/main.php';

    // remove the following lines when in production mode
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    // specify how many levels of call stack should be shown in each log message
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

    
    if (apc_exists( $cacheKey )){
        $config = apc_fetch($cacheKey);
    }
    else{
        $backendConfig = require(dirname(__FILE__) . '/backend/config/backendConfig.php');
        $local = require(dirname(__FILE__) . '/protected/config/main-local.php');
        $base=require( dirname(__FILE__).'/protected/config/main.php' );
        $config = CMap::mergeArray($base,$local);
        $config = CMap::mergeArray($config, $backendConfig);
        apc_store($cacheKey, $config , 30);
    }
    

    Yii::createWebApplication($config)->run();
}