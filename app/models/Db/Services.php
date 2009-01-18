<?php

require_once 'Streams.php';

class Services extends Common_Db_Table
{
    protected $_name = 'services';
    protected $_primary = 'id';

    protected $_dependentTables = array('Streams', 'ServiceOptions');

    public function insert(array $data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        return parent::insert($data);
    }

    public function update(array $data, $where)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
}
