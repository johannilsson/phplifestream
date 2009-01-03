<?php

require_once 'Zend/Controller/Action.php';
 
class IndexController extends Zend_Controller_Action 
{
    protected $_streamEntryModel = null;

    protected function _getStreamEntryModel() 
    { 
        if (null === $this->_streamEntryModel) { 
            require_once APPLICATION_PATH . '/models/StreamEntryModel.php'; 
            $this->_streamEntryModel = new StreamEntryModel(); 
        } 
        return $this->_streamEntryModel; 
    }

    public function indexAction() 
    {
        $this->view->entries = $this->_getStreamEntryModel()->fetchEntries($this->_getParam('page', 1));
    }

} 
