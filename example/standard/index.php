<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

//load autoloader
require_once '../../vendor/autoload.php';

//init app
$app = new hubert\app();
$app->registerNamespace("app", __dir__."/app/");
$app->loadConfig(__dir__.'/config/');
//$app->loadConfig(__dir__.'/config/container/', __dir__.'/data/cache/config_cache.php');

//run and emit app
$app->emit($app->run());

