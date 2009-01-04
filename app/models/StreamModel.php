<?php

require_once 'Db/Streams.php';

class StreamModel
{
    const ITEM_COUNT_PER_PAGE = 20;
    const PAGE_RANGE = 10;

    private $_dbTable = null;

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->_dbTable = new Streams();
        }
        return $this->_dbTable;
    }

    public function add(array $data) 
    {
        $db = $this->getDbTable();

        $entry = $db->fetchRow($db->select()->where('unique_id = ?', $data['unique_id']));
        if (null == $entry) {
            $id = $db->insert($data);
        } else {
            $where = $db->getAdapter()->quoteInto('unique_id = ?', $data['unique_id']);
            $db->update($data, $where);            
        }
    }

    public function fetchEntries($page = null)
    {
        $select = $this->getDbTable()->select()
            ->setIntegrityCheck(false)
            ->from('streams')
            ->join('services', 'services.id = streams.service_id', array('code', 'display_content'))
            ->order('content_updated_at desc')
            ->order('content_created_at desc')
            ->order('streams.created_at desc');

        $entries = $this->getDbTable()->fetchAll(
            $select
        );

        if (null !== $page) {
            $entries = $this->_paginateResult($entries, $page);
        }

        return $entries;
    }

    private function _paginateResult($entries, $page)
    {
        $entries  = Zend_Paginator::factory($entries);
        $entries->setItemCountPerPage(self::ITEM_COUNT_PER_PAGE)
            ->setPageRange(self::PAGE_RANGE)
            ->setCurrentPageNumber($page);    
        return $entries;
    }

}