<?php

class Zend_View_Helper_StreamFeed
{
    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * 
     * @param $streamEntries
     * @param $format
     * @return Zend_Feed_Abstract
     */
    public function streamFeed($streamEntries, $format = 'atom')
    {
        $entries = array();
        foreach ($streamEntries as $entry) {
            $updatedAt = $this->view->date($entry->updated_at);
            $entry = array(
            'title'        => $entry->title, //required
            'link'         => $this->view->appUrl() . $this->view->url(array('action' => 'view', 'id' => $entry->id, 'format' => null)), //required
            'description'  => $entry->title, // only text, no html, required
            'guid'         => $entry->id,
            //'content'      => $entry->title, // can contain html, optional
            'lastUpdate'   => $updatedAt->get(Zend_Date::TIMESTAMP), // optional
            'source'       => array(
                                   'title' => $entry->title, // required,
                                   'url' => $entry->url // required
                                   ) // original source of the feed entry // optional
            );
            $entries[] = $entry;
        }
        
        //$entry = $this->entries->getItem(0);
        //$updatedAt = $this->date($entry->updated_at);
        //$createdAt = $this->date($entry->created_at);
        
        $data = array(
              'title'       => 'My Lifestream', //required
              'link'        => $this->view->appUrl(), //required
              //'lastUpdate'  => $updatedAt->get(Zend_Date::TIMESTAMP), // optional
              //'published'   => $createdAt->get(Zend_Date::TIMESTAMP), //optional
              'charset'     => 'utf-8', // required
              //'description' => 'short description of the feed', //optional
              'generator'   => 'PHP Lifestream', // optional
              'language'    => 'language the feed is written in', // optional
              'ttl'         => '5',
              'entries'     => $entries
        );

        $feedBuilder = new Zend_Feed_Builder($data);

        return Zend_Feed::importBuilder($feedBuilder, $format);
    }
}
