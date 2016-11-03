<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
//load autoloader
require_once '../../vendor/autoload.php';
//init app
$app = new hubert\app();
$config = array(
    "config" => array(
        "display_errors" => true,
    ),
    "routes" => array(
            "home" => array(
                "route" => "/", 
                "method" => "GET|POST", 
                "target" => function($request, $response, $args){
                    echo "Hello World";
                }
            )
        )
);
$app->loadConfig($config);
//run and emit app
$app->emit($app->run());
