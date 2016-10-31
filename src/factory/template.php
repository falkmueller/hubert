<?php

namespace hubert\factory;

class template {
    
    public static function getTemplateEngine($container){
        $engine =  new \League\Plates\Engine($container["config"]["template"]["path"]);
    
        $engine->setFileExtension($container["config"]["template"]["fileExtension"]);

        if(isset($container["config"]["template"]["extensions"])){
            foreach ($container["config"]["template"]["extensions"] as $classname){
                $extension = new $classname();
                if(method_exists($extension,"setContainer")){
                    call_user_func(array($extension, "setContainer"), $container);
                }
                $engine->loadExtension($extension);
            }
        }
        
        return $engine;
    }

}