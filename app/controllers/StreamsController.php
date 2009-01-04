<?php

require_once 'Zend/Controller/Action.php';

class StreamsController extends Zend_Controller_Action 
{
    protected $_streamEntryModel = null;

    protected function _getStreamModel() 
    {
        if (null === $this->_streamEntryModel) { 
            require_once APPLICATION_PATH . '/models/StreamModel.php'; 
            $this->_streamEntryModel = new StreamModel(); 
        } 
        return $this->_streamEntryModel; 
    }

    public function homeAction() 
    {
        $this->view->entries = $this->_getStreamModel()->fetchEntries($this->_getParam('page', 1));
    }

} 
