<?php

namespace hubert\factory;

use Zend\Diactoros\ServerRequestFactory;

class request {
    
    public static function getRequest($container){
        return ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );
    }
}
