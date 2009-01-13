<?php

class Zend_View_Helper_AppUrl extends Zend_View_Helper_Abstract
{
    /**
     * @var string
     */
    protected $_appUrl;

    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * Return the http host
     * 
     * @return string
     */
    public function appUrl()
    {
        if (null === $this->_appUrl) {
            if (isset($this->view->appUrl)) {
                $this->_httpHost = $this->view->appUrl;
            } else {
                $httpHost = $this->view->httpHost();
                $baseUrl = $this->view->baseUrl();
                $this->_appUrl = $httpHost . $baseUrl;
            }
        }

        return 'http://' . $this->_appUrl;
    }
}
