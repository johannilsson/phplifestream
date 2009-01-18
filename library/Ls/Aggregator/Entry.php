<?php

class Ls_Aggregator_Entry
{
    private $_uniqueId;
    private $_url;
    private $_title;
    private $_summary;
    private $_content;
    private $_contentCreatedAt;
    private $_contentUpdatedAt;
    private $_categories = array();

    public function toArray()
    {
        return array(
            'unique_id'            => $this->_uniqueId,
            'url'                  => $this->_url,
            'title'                => $this->_title,
            'summary'              => $this->_summary,
            'content'              => $this->_content,
            'content_created_at'   => $this->_contentCreatedAt,
            'content_updated_at'   => $this->_contentUpdatedAt,
            'categories'           => $this->_categories,
        );
    }

    public function setUniqueId($value)
    {
        $this->_uniqueId = (string) $value;   
    }

    public function setUrl($value)
    {
        $this->_url = (string) $value;   
    }

    public function setTitle($value)
    {
        $this->_title = (string) $value;   
    }

    public function setSummary($value)
    {
        $this->_summary = (string) $value;   
    }

    public function setContent($value)
    {
        $this->_content = (string) $value; 
    }

    public function setContentCreatedAt($value)
    {
        $this->_contentCreatedAt = (string) $value;   
    }

    public function setContentUpdatedAt($value)
    {
        $this->_contentUpdatedAt = (string) $value;   
    }

    public function setCategories(array $categories)
    {
        $this->_categories = $categories;   
    }

    public function addCategory($category)
    {
        $this->_categories[] = (string) $category;
    }
    
    public function getUniqueId()
    {
        return $this->_uniqueId;   
    }

    public function getUrl()
    {
        return $this->_url;   
    }

    public function getTitle()
    {
        return $this->_title;   
    }

    public function getSummary()
    {
        return $this->_summary;   
    }

    public function getContent()
    {
        return $this->_content;   
    }

    public function getContentCreatedAt()
    {
        return $this->_contentCreatedAt;   
    }

    public function getContentUpdatedAt()
    {
        return $this->_contentUpdatedAt;   
    }

    public function getCategories()
    {
        return $this->_categories;   
    }
}