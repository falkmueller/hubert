<?php

/**
 * http://altorouter.com/
 */
return array(
    
    "factories" => array(
        "router" => array(hubert\factory\router::class, 'getRouter'),
        "notFoundHandler" => array(hubert\factory\router::class, 'getNotFoundHandler'),
        "dispatch" => array(hubert\factory\router::class, 'getDispatch')
    ),
    
    "config" => array(
        "controller_namespace" => "app\\controller",
        "routes" => array(
            "home" => array(
                "route" => "/", 
                "method" => "GET|POST", 
                "target" => array("controller" => "index", "action" => "index")
            )
        )
    ),
);
