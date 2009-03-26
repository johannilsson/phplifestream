<?php

define('APPLICATION_PATH', dirname(__FILE__));
defined('ENVIRONMENT')
    or define('ENVIRONMENT', 'production');

$includePath = array(
    dirname(__FILE__) . '/../library',
    get_include_path(),
);
set_include_path(implode(PATH_SEPARATOR, $includePath));

require_once 'Zend/Loader.php';
Zend_Loader::registerAutoload();

date_default_timezone_set('UTC');

$appConfig = new Zend_Config_Ini(APPLICATION_PATH . '/conf/app.ini', ENVIRONMENT);
Zend_Registry::set('appConfig', $appConfig);

$db = Zend_Db::factory($appConfig->db);
//$db->query('SET NAMES UTF8');
Zend_Db_Table_Abstract::setDefaultAdapter($db);
Zend_Registry::set('db', $db);

// Database caching
$frontendOptions = array(
        'automatic_serialization' => true
    );
$backendOptions  = array(
        'cache_dir' => APPLICATION_PATH . '/../tmp/',
    );
$cache = Zend_Cache::factory('Core',
                             'File',
                             $frontendOptions,
                             $backendOptions);
Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);

// TODO: Move to config
$writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../log/app_log');
$filter = new Zend_Log_Filter_Priority(Zend_Log::INFO);
$logger = new Zend_Log($writer);
$logger->addFilter($filter);

Zend_Registry::set('logger', $logger);
