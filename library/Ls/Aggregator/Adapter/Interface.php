<?php

interface Ls_Aggregator_Adapter_Interface
{
    /**
     * Set options
     * 
     * @return array
     */
    public function setOptions(array $options = array());

    /**
     * List of required options for this aggregator
     * 
     * @return array
     */
    public function getRequiredOptions();

    /**
     * Fetch entries from service
     * 
     * @throws Ls_Aggregator_Exception
     * @return array with Ls_Aggregator_Entry items
     */
    public function fetchEntries();
}