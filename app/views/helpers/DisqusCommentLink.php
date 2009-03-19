<?php

class Zend_View_Helper_DisqusCommentLink
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
    public function disqusCommentLink($entry)
    {
        $config = Zend_Registry::get('appConfig');
        if ("" != ($shortName = $config->disqus->shortName)) {
            $params = array('entry' => $entry);
            return $this->view->partial('_disqus_comment_link.phtml', $params);
        }        
    }

}
