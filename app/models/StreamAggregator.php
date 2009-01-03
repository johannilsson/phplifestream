<?php

require_once 'Db/Streams.php';

class StreamAggregator 
{
    private $_streamsDb = null;

    public function getStreamsDb()
    {
        if (null === $this->_streamsDb) {
            $this->_streamsDb = new Streams();
        }
        return $this->_streamsDb;
    }

    public function aggregate()
    {
        $entries = array();
        foreach ($this->getStreamsDb()->fetchAll() as $streamRow) {
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
                $entry['content_id_hash'] = md5($entry['content_id']);
                $entries[] = $entry;
            }
        }
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