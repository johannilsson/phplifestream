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

$dsConfig = new Zend_Config_Ini(APPLICATION_PATH . '/conf/db.ini', ENVIRONMENT);
$db = Zend_Db::factory($dsConfig->db);
//$db->query('SET NAMES UTF8');
Zend_Db_Table_Abstract::setDefaultAdapter($db);
Zend_Registry::set('db', $db);

