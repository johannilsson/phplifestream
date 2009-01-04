<?php

require_once 'Zend/Controller/Action.php';

class IndexController extends Zend_Controller_Action 
{
    /**
     * Index action
     *
     */
    public function indexAction() 
    {
        $this->_redirect($this->_helper->url('home', 'streams'));
    }

} 
