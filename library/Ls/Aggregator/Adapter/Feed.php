<?php

class Ls_Aggregator_Adapter_Feed implements Ls_Aggregator_Adapter_Interface
{
    const URL = "url";

    private $_url;

    public function __construct(array $options = array())
    {
        foreach ($options as $key => $value) {
            switch ($key) {
                case self::URL:
                    $this->setUrl($value);
                    break;
            }
        }        
    }

    public function setUrl($url)
    {
        $this->_url = $url;
    }

    public function fetchEntries()
    {
        $entries = array();
        try
        {
            $feed = Zend_Feed::import($this->_url);

            $date = new Zend_Date();

            foreach ($feed as $item) {
                $entry = new Ls_Aggregator_Entry();
                $entry->setUrl($item->link('alternate'));
                $entry->setUniqueId(md5($entry->getUrl()));
                $entry->setTitle($item->title);
                $entry->setContentUpdatedAt($this->_createDate($item->updated));
                $entry->setContent($item->content);

                if ($feed instanceof Zend_Feed_Atom) {
                    $entry->setSummary($item->summary);
                    $entry->setContentCreatedAt($this->_createDate($item->published));
                } else {
                    $entry->setSummary($item->description);
                    $entry->setContentCreatedAt($this->_createDate($item->pubDate));
                }

                // Make sure we have both created and updated with something
                if ($entry->getContentUpdatedAt() == '') {
                    $entry->setContentUpdatedAt($entry->getContentCreatedAt());
                }
                if ($entry->getContentCreatedAt() == '') {
                    $entry->setContentCreatedAt($entry->getContentUpdatedAt());
                }

                $entries[] = $entry;
            }                 
        } catch (Zend_Http_Client_Adapter_Exception $e) {
            ; // Silent for now...
        }
        return $entries;
    }

    private function _createDate($date)
    {
        try {
            return new Zend_Date($date);
        } catch (Zend_Date_Exception $e) {
            return null;   
        }
    }
}