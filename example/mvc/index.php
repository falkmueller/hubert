<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
//load autoloader
require_once '../../vendor/autoload.php';

//init app
$app = new hubert\app();
$app->registerNamespace("src", __dir__."/src/");
$app->loadConfig(__dir__.'/config/');
//to cache the configuration
//$app->loadContainer(__dir__.'/config/', __dir__.'/data/cache/config_cache.php');

//run and emit app
$app->emit($app->run());
