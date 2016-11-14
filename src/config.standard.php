<?php 

return array(
     "factories" => array(
        "core" => array(\hubert\service\core::class, 'factory'),
        "request" => array(\hubert\service\request::class, 'factory'),
        "errorHandler" => array(\hubert\service\errorHandler::class, 'factory'),
        "router" => array(\hubert\service\router::class, 'factory'),
        "dispatch" => array(\hubert\service\dispatcher::class, 'factory')
         ),
    
     "config" => array(

     ) 
);
