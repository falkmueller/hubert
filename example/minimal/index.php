<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
//load autoloader
require_once '../../vendor/autoload.php';

//create configuration
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
                "target" => function($request, $response, $args){
                    echo "Route with param and optionan trilling slash: ";
                    $router = hubert()->router;
                    echo $router->get("test", array("controller" => $args["controller"]));
                }
            ),
        )
);
            
//init hubert            
hubert($config);

//run and emit app
hubert()->core()->run();
