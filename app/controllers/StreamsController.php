<?php

require_once 'Zend/Controller/Action.php';

class StreamsController extends Zend_Controller_Action 
{
    protected $_streamEntryModel = null;

    public function init()
    {
        $contexts = array(
          'atom' => array(
                'suffix'  => 'atom', 
                'headers' => array(
                 //   'Content-Type' => 'application/atom+xml',
                ),
          ), 
          'rss' => array(
            'suffix'  => 'rss', 
            'headers' => array(
                'Content-Type' => 'application/rss+xml',
            ),
          )
        );
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addContexts($contexts)
                      ->addActionContext('list', array('atom', 'rss'))
                      ->initContext();
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
        $this->_redirect($this->_helper->url('list', 'streams'));
    }

    /**
     * Keep this action for legacy a while.
     */ 
    public function homeAction() 
    {
        $this->_redirect($this->_helper->url('list', 'streams'));
    }

    public function listAction() 
    {
        $this->view->entries = $this->_getStreamModel()->fetchEntries($this->_getParam('page', 1));
    }

    public function viewAction() 
    {
        $this->view->entry = $this->_getStreamModel()->fetchEntry($this->_getParam('id', null));
    }
} 
