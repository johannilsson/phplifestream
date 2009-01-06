<?php

class Ls_Aggregator_Adapter_GoogleReader extends Ls_Aggregator_Adapter_Feed
{
    protected function _createEntry($item)
    {
        $entry = parent::_createEntry($item);
        $entry->setContentCreatedAt(Zend_Date::now());
        $entry->setContentUpdatedAt(Zend_Date::now());
        return $entry;
    }
}