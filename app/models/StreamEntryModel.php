<?php

require_once 'Db/StreamEntries.php';

class StreamEntryModel
{
    const ITEM_COUNT_PER_PAGE = 20;
    const PAGE_RANGE = 10;

    private $_dbTable = null;

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->_dbTable = new StreamEntries();
        }
        return $this->_dbTable;
    }

    public function add(array $data) 
    {
        $db = $this->getDbTable();

        $entry = $db->fetchRow($db->select()->where('content_id_hash = ?', $data['content_id_hash']));
        if (null == $entry) {
            $id = $db->insert($data);
        } else {
            $where = $db->getAdapter()->quoteInto('content_id_hash = ?', $data['content_id_hash']);
            $db->update($data, $where);            
        }
    }

    public function fetchEntries($page = null)
    {
        $select = $this->getDbTable()->select()
            ->setIntegrityCheck(false)
            ->from('stream_entries')
            ->join('streams', 'streams.id = stream_entries.stream_id', array('code', 'display_content'))
            ->order('content_updated_at desc')
            ->order('content_created_at desc')
            ->order('stream_entries.created_at desc');

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