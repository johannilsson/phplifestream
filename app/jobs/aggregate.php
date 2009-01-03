<?php

require_once dirname(__FILE__) . '/../bootstrap_cron.php';
require_once APPLICATION_PATH . '/models/StreamModel.php';
require_once APPLICATION_PATH . '/models/StreamEntryModel.php';

echo "--------- \n";
echo "Init \n";

$streamModel = new StreamModel();
$streamEntryModel = new StreamEntryModel();
foreach ($streamModel->aggregate() as $entry) {
    $streamEntryModel->add($entry);
}
echo "Done! \n";