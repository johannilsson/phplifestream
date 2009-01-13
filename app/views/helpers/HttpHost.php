<?php

class Zend_View_Helper_HttpHost extends Zend_View_Helper_Abstract
{
    /**
     * @var string
     */
    protected $_httpHost;

    /**
     * Return the http host
     * 
     * @return string
     */
    public function httpHost()
    {
        if (null === $this->_httpHost) {
            if (isset($this->view->httpHost)) {
                $this->_httpHost = $this->view->baseUrl;
            } else {
                $request = Zend_Controller_Front::getInstance()->getRequest();
                $this->_httpHost = $request->getHttpHost();
            }
        }

        return $this->_httpHost;
    }
}
