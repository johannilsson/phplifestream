<?php

require_once dirname(__FILE__) . '/bootstrap.php';
require_once APPLICATION_PATH . '/models/StreamModel.php';
require_once APPLICATION_PATH . '/models/StreamEntryModel.php';

echo "---------";
echo "Init \n";

$streamModel = new StreamModel();
$streamEntryModel = new StreamEntryModel();
foreach ($streamModel->aggregate() as $entry) {
    $streamEntryModel->add($entry);
}
echo "Done! \n";