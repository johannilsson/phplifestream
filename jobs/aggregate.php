<?php

require_once dirname(__FILE__) . '/bootstrap.php';
require_once APPLICATION_PATH . '/models/StreamAggregator.php';
require_once APPLICATION_PATH . '/models/Stream.php';

$aggregator = new StreamAggregator();
$stream = new Stream();
foreach ($aggregator->aggregate() as $entry) {
    $stream->add($entry);
}