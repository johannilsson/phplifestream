<?php

require_once 'Zend/Controller/Action.php';
require_once APPLICATION_PATH . '/models/TaggedStreamModel.php';
require_once APPLICATION_PATH . '/models/TagModel.php';

class TagsController extends Zend_Controller_Action 
{
    public function showAction() 
    {
        $tag = TagModel::getInstance()->fetchEntryByCleanName($this->_getParam('name'));
        if (null === $tag) {
            return $this->_forward('notfound', 'error');
        }

        $taggedStreamModel = TaggedStreamModel::getInstance();

        $entries = $this->_paginateResult(
            $taggedStreamModel->fetchStreamsByTag($tag), 
            $this->_getParam('page', 1));

        $this->view->tag = $tag;
        $this->view->entries = $entries;
    }

    private function _paginateResult($entries, $page)
    {
        $entries  = Zend_Paginator::factory($entries);
        $entries->setItemCountPerPage(50)
            ->setPageRange(10)
            ->setCurrentPageNumber($page);    
        return $entries;
    }
} 
