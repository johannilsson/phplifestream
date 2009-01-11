<?php
class FeedServiceOptionForm extends Zend_Form_SubForm
{
    public function init()
    {
        $this->addElementPrefixPath('Ls', 'Ls/');

        $this->setName('serviceoptionsform');

        $this->addElement('text', 'url', array(
            'label' => 'Feed Url:', 
            'required' => true, 
            'filters' => array('StringTrim'), 
            )); 
    }
}
