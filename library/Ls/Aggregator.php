<?php

class Ls_Aggregator
{
    protected $_aggregator;

    public function __construct($aggregator)
    {
        $this->_aggregator = $aggregator;
    }

    public function fetchEntries()
    {
        $aggregator = $this->getAggregatorInstance();
        return $aggregator->fetchEntries();
    }

    public function getAggregatorInstance()
    {
        $aggregator = $this->_aggregator;
        $args = array();

        if (is_array($aggregator)) {
            $args = $aggregator;
            $aggregator = array_shift($args);
        }

        // TODO: Move to allow other plugins...
        $loader = new Zend_Loader_PluginLoader();
        $loader->addPrefixPath('Ls_Aggregator_Adapter', 'Ls/Aggregator/Adapter/');
        $className = $loader->load($aggregator);

        $class = new ReflectionClass($className);

        if (!$class->implementsInterface('Ls_Aggregator_Adapter_Interface')) {
            require_once 'Ls/Aggregator/Exception.php';
            throw new Ls_Aggregator_Exception('Aggregator must implement interface "Ls_Aggregator_Adapter_Interface".');
        }

        if ($class->hasMethod('__construct')) {
            $object = $class->newInstanceArgs($args);
        } else {
            $object = $class->newInstance();
        }

        return $object;
    }
}
