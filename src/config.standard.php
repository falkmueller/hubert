<?php 

return array(
     "factories" => array(
        "request" => array(\hubert\factory\zend::class, 'getRequest'),
        "eventManager" => array(\hubert\factory\zend::class, 'getEventManager'),
        "exceptionHandler" => array(\hubert\factory\errorHandling::class, 'getExceptionHandler'),
        "router" => array(\hubert\factory\router::class, 'getRouter'),
        "notFoundHandler" => array(\hubert\factory\router::class, 'getNotFoundHandler'),
        "dispatch" => array(\hubert\factory\router::class, 'getDispatch')
         ),
    
     "config" => array(
         
     ) 
);
