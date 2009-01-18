<?php

@include 'phplifestream-conf.php';

defined('BOOTSTRAP_FILE')
    or define('BOOTSTRAP_FILE', dirname(__FILE__) . '/../bootstrap_cron.php');

require_once BOOTSTRAP_FILE;
require_once APPLICATION_PATH . '/models/ServiceModel.php';
require_once APPLICATION_PATH . '/models/StreamModel.php';

set_time_limit(0);

$logger = Zend_Registry::get('logger');

$logger->info('Started aggregate job');

$serviceModel = new ServiceModel();
$streamModel = new StreamModel();

foreach ($serviceModel->aggregate() as $entry) {
    try {
        // Kinda hacky, but keep it like this til we have a better plan
        if (isset($entry['categories'])) {
            $entry['tags'] = $entry['categories'];
            unset($entry['categories']);
        }
        $streamModel->add($entry);
    } catch (DuplicateStreamEntryException $e) {
        ; // We dont care about this here.
    } catch (Exception $e) {
        $logger->info('Got exception ' . $e->getMessage() . '(' . get_class($e) . ')');
    }
}

$logger->info('Finished aggregate job');
