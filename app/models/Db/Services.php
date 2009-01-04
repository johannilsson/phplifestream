<?php

class Services extends Zend_Db_Table_Abstract
{
    protected $_name = 'services';
    protected $_primary = 'id';

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
