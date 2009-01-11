<?php

class Zend_View_Helper_Date
{
    /**
     * Renders a date from another date
     *
     * @param  string $date
     * @return string
     */
    public function date($date = "now")
    {
        $time = strtotime($date);
        $locale = new Zend_Locale();
        $date = new Zend_Date($time, Zend_Date::TIMESTAMP, $locale);

        return $date;
    }
}
