<?php

require_once 'Db/Services.php';

class ServiceModel
{
    private $_dbTable = null;

    public function getDbTable()
    {
        if (null === $this->_streamsDb) {
            $this->_dbTable = new Services();
        }
        return $this->_dbTable;
    }

    public function aggregate()
    {
        $logger = Zend_Registry::get('logger');

        $services = $this->getDbTable()->fetchAll(
            $this->getDbTable()
                ->select()
                ->where('aggregate = ?', true)
        );

        $arrEntries = array();
        foreach ($services as $service) {
            $logger->info('Aggregating ' . $service->name . '.');

            try {
                $options = $this->fetchServiceOptions($service->id);
                $aggregator = new Ls_Aggregator(array($service->aggregator, $options));

                $entries = $aggregator->fetchEntries();
                foreach ($entries as $entry) {
                    $arrEntry = $entry->toArray();
                    $arrEntry['service_id'] = $service->id;
                    $arrEntry['unique_id'] = sha1($entry->getUniqueId() . $service->id);
                    $arrEntries[] = $arrEntry;
                }

                $service->aggregated_at = date('Y-m-d, H:i:s', time());
                $service->save();
            } catch (Exception $e) {
                $logger->alert('Got Exception ' . $e->getMessage() 
                    . '(' . get_class($e) . ').');
            }
        }
        $logger->debug('Got ' . count($arrEntries) . ' entries.');
        return $arrEntries;
    }

    public function fetchServiceOptions($serviceId)
    {
        $select = $this->getDbTable()->select()
            ->setIntegrityCheck(false)
            ->from('service_options')
            ->where('service_id = ?', $serviceId);
        $options = $this->getDbTable()->fetchAll($select);
        $arrOptions = array();
        foreach ($options as $row) {
            $arrOptions[$row->name] = $row->value; 
        }
        return $arrOptions;
    }

    public function fetchEntries()
    {
        $select = $this->getDbTable()->select()->order('name');
        $entries = $this->getDbTable()->fetchAll(
            $select
        );
        return $entries;
    }
}