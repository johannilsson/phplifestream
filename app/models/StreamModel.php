<?php

require_once 'Db/Streams.php';

class StreamModel
{
    private $_dbTable = null;

    public function getDbTable()
    {
        if (null === $this->_streamsDb) {
            $this->_dbTable = new Streams();
        }
        return $this->_dbTable;
    }

    public function aggregate()
    {
        $entries = array();
        foreach ($this->getDbTable()->fetchAll() as $streamRow) {
            try
            {
                $feed = Zend_Feed::import($streamRow->url);
    
                $entry = array();
                foreach ($feed as $item) {
                    $entry['stream_id'] = $streamRow->id;
                    $entry['title'] = $item->title;
                    $entry['url'] = $item->link('alternate');
                    $entry['content_updated_at'] = $this->_getDate($item->updated);
                    $entry['content'] = $item->content;
                    if ($feed instanceof Zend_Feed_Atom) {
                        $entry['summary'] = $item->summary;
                        $entry['content_id'] = $item->id;
                        $entry['content_created_at'] = $this->_getDate($item->published);
                    } else {
                        $entry['summary'] = $item->description;
                        $entry['content_id'] = $item->guid;
                        $entry['content_created_at'] = $this->_getDate($item->pubDate);
                    }
    
                    // Make sure we have both created and updated with something
                    if ($entry['content_updated_at'] == '') {
                        $entry['content_updated_at'] = $entry['content_created_at'];
                    }
                    if ($entry['content_created_at'] == '') {
                        $entry['content_created_at'] = $entry['content_updated_at'];
                    }
    
                    $entry['content_id_hash'] = md5($entry['content_id']);
                    $entries[] = $entry;
                }                 
            } catch (Zend_Http_Client_Adapter_Exception $e) {
                ; // Silent for now...
            }
        }
        return $entries;
    }

    public function fetchEntries()
    {
        $select = $this->getDbTable()->select();
        $entries = $this->getDbTable()->fetchAll(
            $select
        );
        return $entries;
    }
    
    private function _getDate($date)
    {
        try {
            return new Zend_Date($date);
        } catch (Zend_Date_Exception $e) {
            return null;   
        }
    }
}