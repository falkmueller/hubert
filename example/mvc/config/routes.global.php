<?php

return array(
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
            )
        )
);
