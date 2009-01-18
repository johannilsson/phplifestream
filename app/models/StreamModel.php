<?php

require_once 'Db/Streams.php';
require_once 'TaggedStreamModel.php';
require_once 'DuplicateStreamEntryException.php';

class StreamModel
{
    const ITEM_COUNT_PER_PAGE = 50;
    const PAGE_RANGE = 10;

    private $_table = null;

    public function getTable()
    {
        if (null === $this->_table) {
            $this->_table = new Streams();
        }
        return $this->_table;
    }

    /**
     * Add new stream entry
     * @param $data
     * @throws DuplicateStreamEntryException
     * @return int Id of added item
     */
    public function add(array $data) 
    {
        $logger = Zend_Registry::get('logger');
        $db = $this->getTable();
        
        if (!isset($data['unique_id'])) {
            $data['unique_id'] = $this->createUniqueId(
                $data['content_unique_id'], 
                $data['service_id']);
        }

        $entry = $db->fetchRow($db->select()->where('unique_id = ?', $data['unique_id']));
        $id = null;
        if (null == $entry) {
            $tags = isset($data['tags']) ? $data['tags'] : array();
            unset($data['tags']);

            $id = $db->insert($data);

            $taggedStreamsModel = TaggedStreamModel::getInstance();
            $taggedStreamsModel->addTagsToStream($tags, $id);

            $logger->info('Added entry ' . $data['unique_id'] . '.');
        } else {
            // Uncomment to always aggregate tags...
            //$tags = isset($data['tags']) ? $data['tags'] : array();
            //$taggedStreamsModel = TaggedStreamModel::getInstance();
            //$taggedStreamsModel->addTagsToStream($tags, $entry->id);

            $logger->debug('Entry exists ' . $data['unique_id'] . '.');
            throw new DuplicateStreamEntryException('Entry already exists');
        }
        return $id;
    }

    public function update(array $data, $streamId) 
    {
        throw new Exception('Method not implemented');
    }

    public function addOrUpdate()
    {
        throw new Exception('Method not implemented');
    }

    public function createUniqueId($contentId, $serviceId)
    {
        return sha1($contentId . $service->id);
    }

    public function destroyByService($serviceId)
    {
        $table = $this->getTable();
        $where = $table->getAdapter()->quoteInto('service_id = ?', $serviceId);
        $table->delete($where);
    }

    public function fetchEntries($page = null)
    {
        $select = $this->getTable()->select()
            ->setIntegrityCheck(false)
            ->from('streams')
            ->join('services', 'services.id = streams.service_id', array('code', 'display_content'))
            ->order('content_updated_at desc')
            ->order('content_created_at desc')
            ->order('streams.created_at desc');

        $entries = $this->getTable()->fetchAll(
            $select
        );

        if (null !== $page) {
            $entries = $this->_paginateResult($entries, $page);
        }

        return $entries;
    }

    public function fetchEntry($id)
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException('id is not numeric was "' . gettype($id) . '"');
        }

        $select = $this->getTable()->select()
            ->setIntegrityCheck(false)
            ->from('streams')
            ->join('services', 'services.id = streams.service_id', array('code', 'name', 'display_content'))
            ->where('streams.id = ?', $id);

        return $this->getTable()->fetchRow($select);
    }

    private function _paginateResult($entries, $page)
    {
        $entries  = Zend_Paginator::factory($entries);
        $entries->setItemCountPerPage(self::ITEM_COUNT_PER_PAGE)
            ->setPageRange(self::PAGE_RANGE)
            ->setCurrentPageNumber($page);    
        return $entries;
    }

    public function fetchEntriesPerService()
    {
        $total = $this->getTable()->fetchRow(
            $this->getTable()->select()->from('streams', array('total' => 'COUNT(*)'))
        );
        $total = $total->total;

        $select = $this->getTable()->select()
            ->setIntegrityCheck(false)
            ->from('services', array('name'))
            ->join('streams', 'services.id = streams.service_id',
                array('entries_per_service' => 'COUNT(*)'))
            ->group('streams.service_id');

        $entries = $this->getTable()->fetchAll(
            $select
        );

        $stats = array();
        foreach ($entries as $entry) {
            $percent = round($entry->entries_per_service / $total * 100, 2);
            $stats[$entry->name] = $percent;
        }
        return $stats;
    }
}