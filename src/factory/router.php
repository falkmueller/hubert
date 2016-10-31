<?php

namespace hubert\factory;

class router {
    
    public static function getRouter($container){
        $ServerParams = $container["request"]->getServerParams(); 
        $basePath = (dirname($ServerParams['SCRIPT_NAME']) != '/' ? dirname($ServerParams["SCRIPT_NAME"]): ''); 
        $router = new \hubert\service\router($basePath); 
        
        if(isset($container["config"]["routes"])){
            $routes = $container["config"]["routes"];
            if(is_array($routes) && count($routes) > 0){
                foreach ($routes as $route_name => $route){
                    $router->add($route_name, $route["route"], $route["target"], (isset($route["method"]) ? $route["method"] : "GET|POST"));
                }
            }
        }
        
        return $router;
    }
    
    public static function getNotFoundHandler($container){
        return function($response){
           if(!$response || !($response instanceof \Zend\Diactoros\Response)){
               $response = new  \Zend\Diactoros\Response();
           }
           $response = $response->withStatus(404);
           $response->getBody()->write("Page not Found.");
           return $response;
       };
    }
    
    public static function getDispatch($container){
        return function() use ($container){
            $response = new \Zend\Diactoros\Response();
            $current_route = $container["router"]->match($container["request"]->getUri()->getPath(),$container["request"]->getMethod());
            $container["current_route"] = $current_route;
            
            if(!is_array($current_route)){
                return $container["notFoundHandler"]($response);
            }
             
            if(is_callable($current_route["target"])){
                return $current_route["target"]($container["request"], $response, $current_route["params"]);
            }

            $target = $current_route["target"];
            $params = $current_route["params"];
            
            $controller = (!empty($params["controller"]) ? $params["controller"] : (!empty($target["controller"]) ? $target["controller"] : "index"));
            $action = (!empty($params["action"]) ? $params["action"] : (!empty($target["action"]) ? $target["action"] : "index"));

            $controller_namespace = $container["config"]["controller_namespace"];
            $classname = $controller_namespace."\\{$controller}Controller";

             if(!class_exists($classname)){
                 throw new \Exception("class {$classname} not exists");
             }

             $myclass = new $classname();
             if(method_exists($myclass,"setContainer")){
                 call_user_func(array($myclass, "setContainer"), $container);
             }
             
             if(method_exists($myclass,"setResponse")){
                 call_user_func(array($myclass, "setResponse"), $response);
             }

             $action_name = $action."Action";

             if(!method_exists($myclass,$action_name)){
                 throw new \Exception("methode {$action_name} in class {$classname} not exists");
             }

             return call_user_func_array(array($myclass, $action_name), array($params) ); 
        };
    }
}
