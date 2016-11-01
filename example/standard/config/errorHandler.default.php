<?php 

return array(
    
    "factories" => array(
        "logger" => array(hubert\factory\errorHandling::class, 'getLogger'),
        "exceptionHandler" => array(hubert\factory\errorHandling::class, 'getExceptionHandler')
    ),
    
    "config" => array(
        "log_path" => dirname(__dir__).'/data/logs/',
        "display_errors" => true
    ),
);
