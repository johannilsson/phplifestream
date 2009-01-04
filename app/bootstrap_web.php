<?php

include_once dirname(__FILE__) . '/bootstrap.php';

$layout = Zend_Layout::startMvc(array(
    'layout'     => 'standard',
    'layoutPath' => APPLICATION_PATH . '/views/layouts',
));

Zend_View_Helper_PaginationControl::setDefaultViewPartial('_search_pagination_control.phtml');
Zend_Paginator::setDefaultScrollingStyle('Sliding');

Zend_Controller_Front::run(APPLICATION_PATH . '/controllers');