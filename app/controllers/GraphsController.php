<?php

require_once 'Zend/Controller/Action.php';

class GraphsController extends Zend_Controller_Action 
{
    protected $_streamEntryModel = null;

    public function init() {
        $this->view->title = Zend_Registry::get('appConfig')->about->title;
    }
    
    protected function _getStreamModel() 
    {
        if (null === $this->_streamEntryModel) { 
            require_once APPLICATION_PATH . '/models/StreamModel.php'; 
            $this->_streamEntryModel = new StreamModel(); 
        } 
        return $this->_streamEntryModel; 
    }

    public function indexAction() 
    {
        $this->view->entries = $this->_getStreamModel()->fetchEntriesPerService();
    }

} 
