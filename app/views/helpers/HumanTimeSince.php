<?php

class Zend_View_Helper_HumanTimeSince
{
    /**
     * Calculates time since in a human friendly format like "about 3 hours".
     *
     * Note: it is possible to pass dates in the future, not worth to add exception
     * or checking for that as it is now...
     *
     * Credits: Based on code by Anonymous at php.net 
     * @link http://se.php.net/manual/en/function.time.php#85481
     * 
     * @param  Zend_Date $date
     * @return string
     */
    public function humanTimeSince(Zend_Date $date)
    {
        $to = Zend_Date::now();
        $distanceInSeconds = round(abs($to->get(Zend_Date::TIMESTAMP) - $date->get(Zend_Date::TIMESTAMP)));
        $distanceInMinutes = round($distanceInSeconds / 60);

        if ( $distanceInMinutes <= 1 ) {
            if ( $distanceInSeconds < 5 ) {
                return 'less than 5 seconds';
            }
            if ( $distanceInSeconds < 10 ) {
                return 'less than 10 seconds';
            }
            if ( $distanceInSeconds < 20 ) {
                return 'less than 20 seconds';
            }
            if ( $distanceInSeconds < 40 ) {
                return 'about half a minute';
            }
            if ( $distanceInSeconds < 60 ) {
                return 'less than a minute';
            }
           
            return '1 minute';
        }
        if ( $distanceInMinutes < 45 ) {
            return $distanceInMinutes . ' minutes';
        }
        if ( $distanceInMinutes < 90 ) {
            return 'about 1 hour';
        }
        if ( $distanceInMinutes < 1440 ) {
            return 'about ' . round(floatval($distanceInMinutes) / 60.0) . ' hours';
        }
        if ( $distanceInMinutes < 2880 ) {
            return '1 day';
        }
        if ( $distanceInMinutes < 43200 ) {
            return 'about ' . round(floatval($distanceInMinutes) / 1440) . ' days';
        }
        if ( $distanceInMinutes < 86400 ) {
            return 'about 1 month';
        }
        if ( $distanceInMinutes < 525600 ) {
            return round(floatval($distanceInMinutes) / 43200) . ' months';
        }
        if ( $distanceInMinutes < 1051199 ) {
            return 'about 1 year';
        }

        return 'over ' . round(floatval($distanceInMinutes) / 525600) . ' years';
    }
}
