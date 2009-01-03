<?php

require_once 'Zend/Controller/Action.php';
 
class IndexController extends Zend_Controller_Action 
{
    protected $_stream = null;

    protected function _getStream() 
    { 
        if (null === $this->_stream) { 
            require_once APPLICATION_PATH . '/models/Stream.php'; 
            $this->_stream = new Stream(); 
        } 
        return $this->_stream; 
    }

    public function indexAction() 
    {
        $this->view->entries = $this->_getStream()->fetchEntries($this->_getParam('page', 1));
    }

} 
