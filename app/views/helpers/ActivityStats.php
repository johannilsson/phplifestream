<?php

require_once APPLICATION_PATH . '/models/StreamModel.php';

class Zend_View_Helper_ActivityStats
{
    const URL = 'http://chart.apis.google.com/chart?';

    public function activityStats($width = 250, $height = 100, $showLegends = true)
    {
        $streamModel = new StreamModel(); 
        $inData = $streamModel->getActivityStats();

        $type    = 'cht=ls';
        $style   = 'chco=000000';
        $size    = 'chs=' . $width . 'x' . $height;
        $data    = 'chd=t:' . implode(',', array_values($inData));
        $legends = $showLegends ? 'chl=' . implode('|', array_keys($inData)) : array();

        return self::URL . implode('&amp;', array($type, $size, $data, $legends, $style));
    }
}
