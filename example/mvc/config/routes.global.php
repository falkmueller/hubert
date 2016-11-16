<?php

return array(
        "factories" => array(
            "preDispatch" => array(src\service\preDispatcher::class, 'get')
        ),
    
        "config" => array(
             "controller_namespace" => "src\\controller"
        ),
    
        "routes" => array(
            "home" => array(
                "route" => "/", 
                "method" => "GET|POST", 
                "target" => array("controller" => "index", "action" => "index")
            ),
            "db" => array(
                "route" => "/db", 
                "method" => "GET|POST", 
                "target" => array("controller" => "index", "action" => "db")
            ),
            "api" => array(
               "route" => "/api", 
               "method" => "GET|POST", 
               "target" => array("controller" => "index", "action" => "api")
           ),
           "controller" => array(
                "route" => "/[:controller][/]?", 
                "method" => "GET|POST", 
                "target" => array("controller" => "index", "action" => "index")
            ),
            "mvc" => array(
                "route" => "/[:controller]/[:action][/]?", 
                "method" => "GET|POST", 
                "target" => array("controller" => "index", "action" => "index")
            ),
        )
);
