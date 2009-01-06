<?php

require_once 'Db/Streams.php';

class StreamModel
{
    const ITEM_COUNT_PER_PAGE = 50;
    const PAGE_RANGE = 10;

    private $_dbTable = null;

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->_dbTable = new Streams();
        }
        return $this->_dbTable;
    }

    public function import(array $data) 
    {
        $logger = Zend_Registry::get('logger');
        $db = $this->getDbTable();

        if (!isset($data['unique_id'])) {
            $data['unique_id'] = $this->createUniqueId(
                $data['content_unique_id'], 
                $data['service_id']);
        }

        $entry = $db->fetchRow($db->select()->where('unique_id = ?', $data['unique_id']));
        if (null == $entry) {
            $id = $db->insert($data);
            $logger->debug('Added entry ' . $data['unique_id'] . '.');
        } else {
            // TODO: Need to add specific importers that sanitize the data, for example
            // google reader does not provide a date when the feed was added.
            // so for now we just strip content_updated_at and content_created_at
            // when updating data...
            // Or add a new field to the streams table for this, maybe affected_my_life_at
            unset($data['content_updated_at']);
            unset($data['content_created_at']);

            $where = $db->getAdapter()->quoteInto('unique_id = ?', $data['unique_id']);
            $db->update($data, $where);

            $logger->debug('Updated entry ' . $data['unique_id'] . '.');
        }
    }

    public function createUniqueId($contentId, $serviceId)
    {
        return sha1($contentId . $service->id);
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