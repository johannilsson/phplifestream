<?php

interface Ls_Aggregator_Adapter_Interface
{
    /**
     * Fetch entries from service
     * 
     * @throws Ls_Aggregator_Exception
     * @return array with Ls_Aggregator_Entry items
     */
    public function fetchEntries();
}