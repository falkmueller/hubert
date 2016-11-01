<?php

namespace hubert\factory;

class errorHandling {
    public static function getLogger($container){
        $log = new \Monolog\Logger('logger');
        if(empty($container["config"]["log_path"])){
            $log->pushHandler(new \Monolog\Handler\TestHandler());
        } else {
           $log->pushHandler(new \Monolog\Handler\StreamHandler($container["config"]["log_path"].date("Y-m-d").'.log', \Monolog\Logger::WARNING));
        }
        return $log;
    }
    
    public static function getExceptionHandler($container){
        return function(\Exception $e) use ($container){
            if(isset($container["logger"])){
                $container["logger"]->error("Code: {$e->getCode()}; Message: {$e->getMessage()}; file: {$e->getFile()}, line: {$e->getLine()}");
            }
            if(!empty($container["config"]["display_errors"])){
                echo "Exception: "."Code: {$e->getCode()}; Message: {$e->getMessage()}; file: {$e->getFile()}, line: {$e->getLine()}";
            }

            echo "Exception: show logs."; 
        };
    }
}
