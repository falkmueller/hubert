<?php

namespace hubert\service;

use Zend\Diactoros\ServerRequestFactory;

class request {
    public static function factory($hubert){
        return ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );
    }
}
