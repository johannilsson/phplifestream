<?php
class ServiceForm extends Zend_Form
{
    public function init()
    {
        $this->addElementPrefixPath('Ls', 'Ls/');

        $this->setName('serviceform');

        $this->addElement('text', 'name', array(
            'label' => 'Name:', 
            'required' => true, 
            'filters' => array('StringTrim'), 
            )); 
        $this->addElement('text', 'code', array(
            'label' => 'Code (service identifier, could be flickr, twitter...):', 
            'required' => true, 
            'filters' => array('StringTrim'), 
            )); 
        $this->addElement('select', 
            'aggregator', array(
            'label' => 'Aggregator',
            'multiOptions' => array('Feed' => 'Feed', 'GoogleReader' => 'GoogleReader'),
            'required' => true, 
            'filters' => array('StringTrim'), 
         ));
        $this->addElement('checkbox', 'aggregate', array(
            'label' => 'Aggregate:', 
            'required' => true, 
            'filters' => array('StringTrim'), 
            )); 
        $this->addElement('checkbox', 'display_content', array(
            'label' => 'Display content in stream:', 
            'required' => true, 
            'filters' => array('StringTrim'), 
            ));
        $this->addElement('text', 'url', array(
            'label' => 'Url:', 
            'required' => true, 
            'filters' => array('StringTrim'), 
            ));
        $this->addElement('submit', 'submit', array(
            'order' => 10000, // We want to have this at the end.
            'label' => 'Save',
            'ignore' => true, // Will not end up in the request params 
            ));
    }
}
