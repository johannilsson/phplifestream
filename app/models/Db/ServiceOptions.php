<?php

class ServiceOptions extends Common_Db_Table
{
    protected $_name = 'service_options';
    protected $_primary = 'id';

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
