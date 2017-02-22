<?php

namespace hubert\service;

class dispatcher {
    
    public static function factory($hubert){
        return new static();
    }
    
    public function __invoke(){
        $response = new \Zend\Diactoros\Response();
        $current_route = hubert()->current_route;

        if(!is_array($current_route)){
            return hubert()->errorHandler->handleNotFound($response);
        }

        elseif (is_callable($current_route["target"])){
            return $current_route["target"](hubert()->request, $response, $current_route["params"]);
        } else {

            $target = $current_route["target"];
            $params = $current_route["params"];

            $controller = (!empty($params["controller"]) ? $params["controller"] : (!empty($target["controller"]) ? $target["controller"] : "index"));
            $action = (!empty($params["action"]) ? $params["action"] : (!empty($target["action"]) ? $target["action"] : "index"));

            $controller_namespace =  (!empty($target["namespace"]) ? $target["namespace"] : (isset(hubert()->config()->controller_namespace) ?  hubert()->config()->controller_namespace : ""));
            $classname = $controller_namespace."\\{$controller}Controller";

            //replace variables in ControlerNamespace
            foreach ($target as $var => $value){
                $classname = str_replace("[$var]", (!empty($params[$var]) ? $params[$var] : $value), $classname);
            }
            
             if(!class_exists($classname)){
                 return hubert()->errorHandler->handleNotFound($response);
             }

             $ControllerInstance = new $classname();

             if(!($ControllerInstance instanceof \hubert\interfaces\controller)){
                 throw new \Exception("controller class {$classname} not implements the controller-interface");
             }

             $ControllerInstance->setResponse($response);
             return $ControllerInstance->dispatch($action, $params);
        }
    }
    
}
