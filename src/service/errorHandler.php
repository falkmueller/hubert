<?php

namespace hubert\service;

class errorHandler {
    
     public static function factory($container){
        return new static(); 
    }
    
    public function handleException(\Exception $e){
         if(isset(hubert()->logger)){
            hubert()->logger->error("Code: {$e->getCode()}; Message: {$e->getMessage()}; file: {$e->getFile()}, line: {$e->getLine()}");
        }
        if(!empty(hubert()->config()->display_errors)){
            echo "Exception: "."Code: {$e->getCode()}; Message: {$e->getMessage()}; file: {$e->getFile()}, line: {$e->getLine()}";
        }

        echo "Exception: show logs."; 
    }
    
    public function handleNotFound($response){
        if(!$response || !($response instanceof \Zend\Diactoros\Response)){
            $response = new  \Zend\Diactoros\Response();
        }
        $response = $response->withStatus(404);
        $response->getBody()->write("Page not Found.");
        return $response;
    }
}
