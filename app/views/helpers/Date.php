<?php

class Zend_View_Helper_Date
{
    /**
     * Sets the view instance.
     *
     * @param  Zend_View_Interface $view View instance
     * @return Zend_View_Helper_Date
     */
    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * Renders a date from another date
     *
     * @param  string $date
     * @return string
     */
    public function date($date)
    {
        $time = strtotime($date);
        $locale = new Zend_Locale();
        $date = new Zend_Date($time, Zend_Date::TIMESTAMP, $locale);
        return $date;
    }
}
