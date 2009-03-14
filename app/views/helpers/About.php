<?php

class Zend_View_Helper_About
{
    public function about()
    {
        $appConfig = Zend_Registry::get('appConfig');

        $about = $appConfig->about;
        $aboutString = '';

        if ($about->picture != '') {
            $aboutString .= '<p><img src="'.$about->picture.'" alt="" /></p>';
        }
        $aboutString .= $about->description;

        return $aboutString;
    }
}
