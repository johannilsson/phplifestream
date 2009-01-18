<?php

require_once 'Services.php';
require_once 'TaggedStreams.php';

class Streams extends Common_Db_Table
{
    protected $_name = 'streams';
    protected $_primary = 'id';

    protected $_dependentTables = array('TaggedStreams');

    protected $_referenceMap    = array(
        'Service' => array(
            'columns'           => array('service_id'),
            'refTableClass'     => 'Services',
            'refColumns'        => array('id'), 
            'onDelete'          => self::CASCADE,
        ),
    );

    public function insert(array $data)
    {
        if ($data['content_created_at'] != '') {
            $date = $this->_createDate($data['content_created_at']);
            $data['content_created_at'] = date('Y-m-d H:i:s', $date->getTimestamp());
        }
        if ($data['content_updated_at'] != '') {
            $date = $this->_createDate($data['content_updated_at']);
            $data['content_updated_at'] = date('Y-m-d H:i:s', $date->getTimestamp());
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        return parent::insert($data);
    }

    public function update(array $data, $where)
    {
        if ($data['content_created_at'] != '') {
            $date = $this->_createDate($data['content_created_at']);
            $data['content_created_at'] = date('Y-m-d H:i:s', $date->getTimestamp());
        }
        if ($data['content_updated_at'] != '') {
            $date = $this->_createDate($data['content_updated_at']);
            $data['content_updated_at'] = date('Y-m-d H:i:s', $date->getTimestamp());
        }
        $data['updated_at'] = date('Y-m-d H:i:s');

        return parent::update($data, $where);
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
