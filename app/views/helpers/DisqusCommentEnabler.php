<?php

class Zend_View_Helper_DisqusCommentEnabler
{
    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
        return $this;
    }
    
    /**
     * Enables disqus comment thread.
     * @return string
     */
    public function disqusCommentEnabler()
    {
        $config = Zend_Registry::get('appConfig');
        if ("" != ($shortName = $config->disqus->shortName)) {
            $params = array('shortName' => $shortName);
            return $this->view->partial('_disqus_comment_enabler.phtml', $params);
        }        
    }

}
