<?php

define('APPLICATION_PATH', dirname(__FILE__));
defined('ENVIRONMENT')
    or define('ENVIRONMENT', 'production');

$includePath = array(
    get_include_path(),
);
set_include_path(implode(PATH_SEPARATOR, $includePath));

require_once 'Zend/Loader.php';
Zend_Loader::registerAutoload();

$dsConfig = new Zend_Config_Ini(APPLICATION_PATH . '/conf/db.ini', ENVIRONMENT);
$db = Zend_Db::factory($dsConfig->db);
Zend_Db_Table_Abstract::setDefaultAdapter($db);
Zend_Registry::set('db', $db);

$layout = Zend_Layout::startMvc(array(
    'layout'     => 'standard',
    'layoutPath' => APPLICATION_PATH . '/views/layouts',
));

Zend_View_Helper_PaginationControl::setDefaultViewPartial('_search_pagination_control.phtml');
Zend_Paginator::setDefaultScrollingStyle('Sliding');

Zend_Controller_Front::run(APPLICATION_PATH . '/controllers');