<?php

namespace hubert\service;

class dispatcher {
    
    public static function factory($hubert){
        return new static();
    }
    
    public function __invoke(){
        $container = hubert();
        
        $response = new \Zend\Diactoros\Response();
        $current_route = $container["router"]->match(urldecode($container["request"]->getUri()->getPath()),$container["request"]->getMethod());
        $container["current_route"] = $current_route;

        if(isset($container["preDispatch"])){
            $predispatch_result = $container["preDispatch"]();
            if($predispatch_result && ($predispatch_result instanceof \Zend\Diactoros\Response)){
                return $predispatch_result;
            }
        }

        $result = null;

        if(!is_array($current_route)){
            $result = hubert()->errorHandler->handleNotFound($response);
        }

        elseif (is_callable($current_route["target"])){
            $result = $current_route["target"]($container["request"], $response, $current_route["params"]);
        } else {

            $target = $current_route["target"];
            $params = $current_route["params"];

            $controller = (!empty($params["controller"]) ? $params["controller"] : (!empty($target["controller"]) ? $target["controller"] : "index"));
            $action = (!empty($params["action"]) ? $params["action"] : (!empty($target["action"]) ? $target["action"] : "index"));


            $controller_namespace =  (!empty($target["namespace"]) ? $target["namespace"] : (isset(hubert()->config()->controller_namespace) ?  hubert()->config()->controller_namespace : ""));
            $classname = $controller_namespace."\\{$controller}Controller";

             if(!class_exists($classname)){
                 throw new \Exception("class {$classname} not exists");
             }

             $ControllerInstance = new $classname();

             if(!($ControllerInstance instanceof \hubert\interfaces\controller)){
                 throw new \Exception("controller class {$classname} not implements the controller-interface");
             }

             $ControllerInstance->setResponse($response);
             $result = $ControllerInstance->dispatch($action, $params);
        }

        if(isset($container["postDispatch"])){
            $postdispatch_result = $container["predispatch"]($result);
            if($postdispatch_result  && ($postdispatch_result instanceof \Zend\Diactoros\Response)){
                $result = $postdispatch_result;
            }
        }

        return $result;
    }
    
}
