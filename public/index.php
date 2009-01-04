<?php

if (file_exists('../phplifestream-conf.php')) {
    require '../phplifestream-conf.php';
}

defined('BOOTSTRAP_FILE')
    or define('BOOTSTRAP_FILE', '../app/bootstrap_web.php');

require_once BOOTSTRAP_FILE;
