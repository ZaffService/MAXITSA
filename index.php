<?php

require_once __DIR__ . '/app/config/bootstrap.php';

if (!APP_DEBUG) {
    error_reporting(0);
    ini_set('display_errors', 0);
}

App::run();
