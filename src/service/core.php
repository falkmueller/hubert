<?php

namespace hubert\service;

class core {
    
    public static function factory($hubert){
        return new static();
    }
    
    public function run($emit = true){
        try {
            $response = $this->route();
            
            if($emit){
                $this->emit($response);
            }
            
            return $response;
        } catch (\Exception $exc) {
            hubert()->errorHandler->handleException($exc);
            exit();
        }
    }
    
    private function route(){
        $bootstraps = array();
        
        //1. bootstrap classes call Init
        if(isset(hubert()->config->bootstrap)){
            $bootstrap_classes = hubert()->config->bootstrap;
            if(!is_array($bootstrap_classes)){
                $bootstrap_classes = array($bootstrap_classes);
            }
            
            foreach ($bootstrap_classes as $bootstrap_class){
                $bootstrap = new $bootstrap_class();
                if($bootstrap instanceof \hubert\interfaces\bootstrap){
                    $bootstrap->init();
                    $bootstraps[] = $bootstrap;
                }
            }
        }
        
        //2. get current Url
        $current_route =  hubert()->router->match(urldecode(hubert()->request->getUri()->getPath()),hubert()->request->getMethod());
        hubert()->current_route = $current_route;
        
        //3. bootstrap classes call predispatch
        foreach ($bootstraps as $bootstrap){
            $dispatch_result = $bootstrap->preDispatch();
            if($dispatch_result && ($dispatch_result instanceof \Zend\Diactoros\Response)){
                return $dispatch_result;
            }
        } 
        
        //4. call preDistach events
        if(isset(hubert()->preDispatch)){
            $dispatchers = hubert()->preDispatch;
            if(is_callable($dispatchers)){
                $dispatchers = array($dispatchers);
            }
            foreach ($dispatchers as $dispatcher){
                $dispatch_result = $dispatcher();
                if($dispatch_result && ($dispatch_result instanceof \Zend\Diactoros\Response)){
                    return $dispatch_result;
                }
            }
        }
        
        //5. call dispatch
        $response = hubert()->dispatch();
        
        //6. call postDistach events
        if(isset(hubert()->postDispatch)){
            $dispatchers = hubert()->postDispatch;
            if(is_callable($dispatchers)){
                $dispatchers = array($dispatchers);
            }
            foreach ($dispatchers as $dispatcher){
                $dispatch_result = $dispatcher($response);
                if($dispatch_result  && ($dispatch_result instanceof \Zend\Diactoros\Response)){
                    $response = $dispatch_result;
                }
            }
        }
        
        //6. call bootstrap classes postDistach events
        foreach ($bootstraps as $bootstrap){
            $dispatch_result = $bootstrap->postDispatch($response);
            if($dispatch_result  && ($dispatch_result instanceof \Zend\Diactoros\Response)){
                $response = $dispatch_result;
            }
        }
        
        //7.return result
        return $response;
        
    }


    public function emit($response){
        if($response && $response instanceof \Zend\Diactoros\Response){
            $emitter = new \Zend\Diactoros\Response\SapiEmitter();
            $emitter->emit($response);
        } elseif (is_string($response)){
            echo $response;
        }   
    }
    
}
