<?php

class StreamEntries extends Zend_Db_Table_Abstract
{
    protected $_name = 'stream_entries';
    protected $_primary = 'id';

    public function insert(array $data)
    {
        if ($data['content_created_at'] instanceof Zend_Date) {
            $date = $data['content_created_at'];
            $data['content_created_at'] = date('Y-m-d H:i:s', $date->getTimestamp());
            $data['content_created_at'] . "\n";
        }
        if ($data['content_updated_at'] instanceof Zend_Date) {
            $date = $data['content_updated_at'];
            $data['content_updated_at'] = date('Y-m-d H:i:s', $date->getTimestamp());
            $data['content_updated_at'] . "\n";
        }

        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        $data['updated_at'] = date('Y-m-d H:i:s');

        return parent::insert($data);
    }

    public function update(array $data, $where)
    {
        if ($data['content_created_at'] instanceof Zend_Date) {
            $date = $data['content_created_at'];
            $data['content_created_at'] = date('Y-m-d H:i:s', $date->getTimestamp());
            $data['content_created_at'] . "\n";
        }
        if ($data['content_updated_at'] instanceof Zend_Date) {
            $date = $data['content_updated_at'];
            $data['content_updated_at'] = date('Y-m-d H:i:s', $date->getTimestamp());
            $data['content_updated_at'] . "\n";
        }
        
        $data['updated_at'] = date('Y-m-d H:i:s');

        return parent::update($data, $where);
    }
}
