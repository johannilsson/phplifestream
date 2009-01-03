<?php

if (file_exists('phplifestream-conf.php')) {
    require 'phplifestream-conf.php';
}

defined('BOOTSTRAP_PATH')
    or define('BOOTSTRAP_PATH', '../app/bootstrap_web.php');

require_once BOOTSTRAP_PATH;
