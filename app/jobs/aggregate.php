<?php

@include 'phplifestream-conf.php';

defined('BOOTSTRAP_FILE')
    or define('BOOTSTRAP_FILE', dirname(__FILE__) . '/../bootstrap_cron.php');

require_once BOOTSTRAP_FILE;
require_once APPLICATION_PATH . '/models/ServiceModel.php';
require_once APPLICATION_PATH . '/models/StreamModel.php';

$logger = Zend_Registry::get('logger');

$logger->info('Started aggregate job');

$serviceModel = new ServiceModel();
$streamModel = new StreamModel();

foreach ($serviceModel->aggregate() as $entry) {
    $streamModel->import($entry);
}

$logger->info('Finished aggregate job');
