<?php

class Zend_View_Helper_MyStreams
{
    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
        return $this;
    }

    public function myStreams()
    {
        require_once APPLICATION_PATH . '/models/StreamModel.php';
        $streamModel = new StreamModel();
        $params = array('entries' => $streamModel->fetchEntries());
        return $this->view->partial('_my_streams.phtml', $params);
    }

}
