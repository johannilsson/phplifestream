<?php

class Zend_View_Helper_PieChart
{
    const URL = 'http://chart.apis.google.com/chart?';

    public function pieChart($inData, $width = 250, $height = 100)
    {
        /*
         *  http://chart.apis.google.com/chart? is the Chart API's location.
         * & separates parameters.
         * chs=250x100 is the chart's size in pixels.
         * chd=t:60,40 is the chart's data.
         * cht=p3 is the chart's type.
         * chl=Hello|World is the chart's label. 
         */
        // chart?cht=p3&chd=t:60,40&chs=250x100&chl=Hello|S anna
        $type    = 'cht=p3';
        $size    = 'chs=' . $width . 'x' . $height;
        $data    = 'chd=t:' . implode(',', array_values($inData));
        $legends = 'chl=' . implode('|', array_keys($inData));

        return self::URL . implode('&', array($type, $size, $data, $legends));
    }
}
