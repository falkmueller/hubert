<?php 

return array(
     "factories" => array(
        "request" => array(\hubert\factory\request::class, 'getRequest'),
        "exceptionHandler" => array(\hubert\factory\errorHandling::class, 'getExceptionHandler'),
        "router" => array(\hubert\factory\router::class, 'getRouter'),
        "notFoundHandler" => array(\hubert\factory\router::class, 'getNotFoundHandler'),
        "dispatch" => array(\hubert\factory\router::class, 'getDispatch')
         ),
    
     "config" => array(

     ) 
);
