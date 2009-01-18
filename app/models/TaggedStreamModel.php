<?php

require_once 'Db/TaggedStreams.php';
require_once 'TagModel.php';

class TaggedStreamModel
{
    private static $_instance = null;
    private $_table = null;

    /**
     * Constructor
     * @return void
     */
    private function __construct()
    {
        ;
    }

    /**
     * Get instance
     * @return unknown_type
     */
    public static function getInstance() 
    {
        if (!self::$_instance instanceof self) { 
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
     * Get table instance.
     * @return unknown_type
     */
    public function getTable()
    {
        if (null === $this->_table) {
            $this->_table = new TaggedStreams();
        }
        return $this->_table;
    }

    /**
     * Add new tagged stream entry
     * @param $tags
     * @param $stream Zend_Db_Table_Row or id 
     * @return int Id of added item
     */
    public function addTagsToStream(array $tags, $stream) 
    {
        $logger = Zend_Registry::get('logger');

        $this->getTable()->addStreamToTags($stream, $tags);
    }

    /**
     * Returns list of most used tags.
     * @param $limit
     * @return unknown_type
     */    
    public function fetchTopEntries($limit = 50)
    {
        $select = $this->getTable()->select()
            ->setIntegrityCheck(false)
            ->from('tagged_streams', array('COUNT(1) as total'))
            ->join('tags', 'tags.id = tagged_streams.tag_id', array('name', 'clean_name'))
            ->group('tag_id')
            ->order('total desc')
            ->limit($limit);

        $entries = $this->getTable()->fetchAll(
            $select
        );
        return $entries;
    }

    /**
     * Returns streams by tag name
     * @param $limit
     * @return array
     */    
    public function fetchStreamsByTag(Common_Db_Table_Row $tag)
    {
        $select = $this->getTable()->select()
            ->setIntegrityCheck(false)
            ->from('streams')
            ->join('tagged_streams', 'streams.id = tagged_streams.stream_id')
            ->join('services', 'services.id = streams.service_id', array('code', 'display_content'))
            ->where('tagged_streams.tag_id = ?', $tag->id)
            ->order('content_updated_at desc')
            ->order('content_created_at desc')
            ->order('streams.created_at desc');

        $entries = $this->getTable()->fetchAll(
            $select
        );
        return $entries;
    }    

    /**
     * Can not clone on singelton
     * @return void
     */
    public function __clone() 
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    /**
     * Can not deserialize on singelton
     * @return void
     */
    public function __wakeup() 
    {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }
}