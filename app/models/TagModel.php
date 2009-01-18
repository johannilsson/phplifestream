<?php

require_once 'Db/Tags.php';

class TagModel
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
     * @return Tags
     */
    public function getTable()
    {
        if (null === $this->_table) {
            $this->_table = new Tags();
        }
        return $this->_table;
    }

    /**
     * Fetch entries
     * @return array
     */
    public function fetchEntries()
    {
        $entries = $this->getTable()->fetchAll(
            $this->getTable()->select()->order('name')
        );
        return $entries;
    }

    /**
     * Fetch entry by name
     * @param $name
     * @return Zend_Db_Table_Row
     */
    public function fetchEntryByCleanName($name)
    {
        $entry = $this->getTable()->fetchRow(
            $this->getTable()->select()->where('clean_name = ?', $name)
        );
        return $entry;
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