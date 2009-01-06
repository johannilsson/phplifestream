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
            foreach ($feed as $item) {
                $entries[] = $this->_createEntry($item);
            }                 
        } catch (Zend_Exception $e) {
            ; // TODO: Add logge, silent for now... 
        }
        return $entries;
    }

    protected function _createEntry(Zend_Feed_Entry_Abstract $item)
    {
        $entry = new Ls_Aggregator_Entry();
        $entry->setUrl($item->link('alternate'));
        $entry->setTitle($item->title);
        $entry->setContent($item->content);

        if ($item instanceof Zend_Feed_Entry_Atom) {
            $entry->setUniqueId($item->id);
            $entry->setSummary($item->summary);
            $entry->setContentCreatedAt($this->_createDate($item->published, Zend_Date::ATOM));
            $entry->setContentUpdatedAt($this->_createDate($item->updated, Zend_Date::ATOM));
        } else {
            $entry->setUniqueId($item->guid);
            $entry->setSummary($item->description);
            $entry->setContentCreatedAt($this->_createDate($item->pubDate, Zend_Date::RSS));
            $entry->setContentUpdatedAt($this->_createDate($item->updated, Zend_Date::RSS));
        }

        // Make sure we have both created and updated with something
        if ($entry->getContentUpdatedAt() == '') {
            $entry->setContentUpdatedAt($entry->getContentCreatedAt());
        }
        if ($entry->getContentCreatedAt() == '') {
            $entry->setContentCreatedAt($entry->getContentUpdatedAt());
        }
        return $entry;
    }

    /**
     * Create a date objects and converts the passed time to UTC.
     * 
     * @param $date
     * @return Zend_Date
     */
    private function _createDate($date, $part)
    {
        echo $date . "\n";
        try {
            $date = new Zend_Date($date, $part);
            $date->setTimezone('UTC');
            echo $date . "\n";
            return $date;
        } catch (Zend_Date_Exception $e) {
            return null;   
        }
    }
}