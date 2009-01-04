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
        $services = $this->getDbTable()->fetchAll();

        $arrEntries = array();
        foreach ($services as $service) {
            $options = $this->fetchServiceOptions($service->id);
            $aggregatorName = ucfirst(strtolower($service->aggregator));
            $aggregator = new Ls_Aggregator(array($aggregatorName, $options));

            $entries = $aggregator->fetchEntries();
            foreach ($entries as $entry) {
                $arrEntry = $entry->toArray();
                $arrEntry['service_id'] = $service->id;
                $arrEntries[] = $arrEntry;
            }

            $service->aggregated_at = date('Y-m-d, H:i:s', time());
            $service->save();
        }
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
        $select = $this->getDbTable()->select();
        $entries = $this->getDbTable()->fetchAll(
            $select
        );
        return $entries;
    }
}