<?php

return array(
    "factories" => array(
         "logger" => array(hubert\extension\logger\factory::class, 'get')
        ),
    
    "config" => array(
        "logger" => array(
            "path" => dirname(__dir__).'/data/logs/',
        )
    )
);
