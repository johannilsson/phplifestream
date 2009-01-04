<?php

@include 'phplifestream-conf.php';

defined('BOOTSTRAP_FILE')
    or define('BOOTSTRAP_FILE', dirname(__FILE__) . '/../bootstrap_cron.php');

require_once BOOTSTRAP_FILE;
require_once APPLICATION_PATH . '/models/ServiceModel.php';
require_once APPLICATION_PATH . '/models/StreamModel.php';

echo "--------- \n";
echo "Init \n";

$serviceModel = new ServiceModel();
$streamModel = new StreamModel();
foreach ($serviceModel->aggregate() as $entry) {
    $streamModel->add($entry);
}

/*
$aggregator = new Ls_Aggregator(array('Feed', array('url' => 'http://example.com/feed.atom')));

$entries = $aggregator->fetchEntries();

foreach ($entries as $entry) {
    print_r($entry);
}

die;
*/

echo "Done! \n";