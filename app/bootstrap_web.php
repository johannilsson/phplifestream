<?php

include_once dirname(__FILE__) . '/bootstrap.php';

$layout = Zend_Layout::startMvc(array(
    'layout'     => 'standard',
    'layoutPath' => APPLICATION_PATH . '/views/layouts',
));

$view = new Zend_View();
$view->setEncoding('UTF-8');
Zend_View_Helper_PaginationControl::setDefaultViewPartial('_search_pagination_control.phtml');
Zend_Paginator::setDefaultScrollingStyle('Sliding');

$frontController = Zend_Controller_Front::getInstance();
$response = new Zend_Controller_Response_Http();
$response->setHeader('Content-Type', 'text/html; charset=UTF-8', true);  
$frontController->setResponse($response);

Zend_Controller_Front::run(APPLICATION_PATH . '/controllers');