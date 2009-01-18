<?php

class Zend_View_Helper_Tags
{
    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
        return $this;
    }

    public function tags()
    {
        require_once APPLICATION_PATH . '/models/TaggedStreamModel.php';
        $model = TaggedStreamModel::getInstance();
        $params = array('entries' => $model->fetchTopEntries());
        return $this->view->partial('_tags.phtml', $params);
    }

}
