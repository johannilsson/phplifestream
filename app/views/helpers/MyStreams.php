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
        require_once APPLICATION_PATH . '/models/ServiceModel.php';
        $serviceModel = new ServiceModel();
        $params = array('entries' => $serviceModel->fetchEntries());
        return $this->view->partial('_my_streams.phtml', $params);
    }

}
