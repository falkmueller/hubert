<?php

namespace hubert\factory;

class errorHandling {   
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
