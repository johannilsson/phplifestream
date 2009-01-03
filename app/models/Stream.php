<?php

require_once 'Db/StreamEntries.php';

class Stream
{
    const ITEM_COUNT_PER_PAGE = 20;
    const PAGE_RANGE = 10;

    private $_streamEntriesDb = null;

    public function getStreamEntriesDb()
    {
        if (null === $this->_streamEntriesDb) {
            $this->_streamEntriesDb = new StreamEntries();
        }
        return $this->_streamEntriesDb;
    }

    public function add(array $data) 
    {
        $db = $this->getStreamEntriesDb();

        $entry = $db->fetchRow($db->select()->where('content_id_hash = ?', $data['content_id_hash']));
        if (null == $entry) {
            $id = $db->insert($data);
        } else {
            $where = $db->getAdapter()->quoteInto('content_id_hash = ?', $id);
            $db->update($data, $where);            
        }
    }

    public function fetchEntries($page = null)
    {
        $select = $this->getStreamEntriesDb()->select()
            ->setIntegrityCheck(false)
            ->from('stream_entries')
            ->join('streams', 'streams.id = stream_entries.stream_id', array('code', 'display_content'))
            ->order('content_created_at desc')
            ->order('content_updated_at desc')
            ->order('stream_entries.created_at desc');

        $entries = $this->getStreamEntriesDb()->fetchAll(
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