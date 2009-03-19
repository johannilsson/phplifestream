<?php

require_once 'Zend/Controller/Action.php';

abstract class AbstractController extends Zend_Controller_Action 
{
    protected $_securedActions = array();

    public function preDispatch()
    {
        $this->auth();
    }

    private function auth()
    {
        // Move this to some auth helper instead, but this works for now.
        $authConf = Zend_Registry::get('appConfig');
        if ($authConf->auth->enabled == false) {
            return false;
        }

        $request = $this->getRequest();
        if (false === Zend_Auth::getInstance()->hasIdentity()) {
            foreach ($this->_securedActions as $action) {
                if ($request->getActionName() == $action) {
                    $this->_forward(
                        $authConf->auth->login->action, 
                        $authConf->auth->login->controller, 
                        $authConf->auth->login->module);
                }
            }
        }
    }
} 
