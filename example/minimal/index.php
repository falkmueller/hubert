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
            ),
            "test" => array(
                "route" => "/[:controller][/]?", 
                "target" => function($request, $response, $args) use ($app){
                    echo "Route with param and optionan trilling slash";
                    $router = $app->getContainer()->router;
                    echo $router->get("test", array("controller" => "ss", "action" => "aaa"));
                }
            ),
        )
);
$app->loadConfig($config);
//run and emit app
$app->emit($app->run());
