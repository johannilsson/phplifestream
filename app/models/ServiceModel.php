<?php

require_once 'Db/Services.php';
require_once 'Db/ServiceOptions.php';

class ServiceModel
{
    private $_streamsDb = null;
    private $_table = null;

    public function getTable()
    {
        if (null === $this->_streamsDb) {
            $this->_table = new Services();
        }
        return $this->_table;
    }
    
    public function add(array $data)
    {
        $serviceOptions = array();
        if (isset($data['service_option'])) {
            $serviceOptions = $data['service_option'];
            unset($data['service_option']);
        }

        $id = $this->getTable()->insert($data);
        $this->addOptions($serviceOptions, $id);
        return $id;
    }

    public function update(array $data, $id)
    {
        $serviceOptions = array();
        if (isset($data['service_option'])) {
            $serviceOptions = $data['service_option'];
            unset($data['service_option']);
        }

        $where = $this->getTable()->getAdapter()->quoteInto('id = ?', $id);

        $this->getTable()->update(
            $data,
            $where);

        $this->updateOptions($serviceOptions, $id);

        return $id;
    }

    public function destroy($service)
    {
        if (false == $service instanceof Zend_Db_Table_Row) {
            $service = $this->fetchEntry($service);            
        }

        $id = $service->id;

        $service->delete();
    }

    public function fetchEntry($id)
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException('id is not numeric was "' . gettype($id) . '"');
        }

        $table = $this->getTable();
        $select = $table->select()->where('id = ?', $id);

        return $table->fetchRow($select);
    }

    public function fetchEntries()
    {
        $select = $this->getTable()->select()->order('name');
        $entries = $this->getTable()->fetchAll(
            $select
        );
        return $entries;
    }

    public function aggregate()
    {
        $logger = Zend_Registry::get('logger');

        $services = $this->getTable()->fetchAll(
            $this->getTable()
                ->select()
                ->where('aggregate = ?', true)
        );

        $arrEntries = array();
        foreach ($services as $service) {
            $logger->info('Aggregating ' . $service->name . '.');

            try {
                $options = $this->fetchOptions($service->id);
                $aggregator = new Ls_Aggregator(array($service->aggregator, $options));

                $entries = $aggregator->fetchEntries();
                foreach ($entries as $entry) {
                    $arrEntry = $entry->toArray();
                    $arrEntry['service_id'] = $service->id;
                    $arrEntry['content_unique_id'] = $entry->getUniqueId();
                    unset($arrEntry['unique_id']);
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

    public function addOptions(array $options, $serviceId)
    {
        $serviceOptions = new ServiceOptions();
        foreach ($options as $optionKey => $optionValue) {
            $option['service_id'] = $serviceId;
            $option['name'] = $optionKey;
            $option['value'] = $optionValue;
            $serviceOptions->insert($option);
        }
    }

    public function updateOptions(array $options, $serviceId)
    {
        $serviceOptions = new ServiceOptions();
        foreach ($options as $optionKey => $optionValue) {
            $option['name'] = $optionKey;
            $option['value'] = $optionValue;

            $where = array();
            $where[] = $serviceOptions->getAdapter()->quoteInto('service_id = ?', $serviceId);
            $where[] = $serviceOptions->getAdapter()->quoteInto('name = ?', $optionKey);

            $serviceOptions->update($option, $where);
        }
    }

    public function fetchOptions($serviceId)
    {
        $select = $this->getTable()->select()
            ->setIntegrityCheck(false)
            ->from('service_options')
            ->where('service_id = ?', $serviceId);
        $options = $this->getTable()->fetchAll($select);
        $arrOptions = array();
        foreach ($options as $row) {
            $arrOptions[$row->name] = $row->value; 
        }
        return $arrOptions;
    }
}