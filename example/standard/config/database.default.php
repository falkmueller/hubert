<?php

//https://docs.zendframework.com/zend-db/

return array(
    "factories" => array(
        "dbAdapter" => array(hubert\factory\zend::class, 'getDatabaseAdapter')
    ),
    
    "config" => array(
        "db" => array(
            'driver'   => 'Mysqli',
            'database' => 'zend_db_example',
            'username' => 'developer',
            'password' => 'developer-password',
        )
    ),
);
