<?php

namespace hubert\service;

class core {
    
    public static function factory($hubert){
        return new static();
    }
    
    public function run($emit = true){
        try {
            $bootstraps = array();
            if(isset(hubert()->config->bootstrap)){
                if(is_array(hubert()->config->bootstrap)){
                    foreach (hubert()->config->bootstrap as $bootstrap_name){
                        $bootstrap = new $bootstrap_name();
                        if($bootstrap instanceof interfaces\bootstrap){
                            $bootstrap->init();
                            $bootstraps[] = $bootstrap;
                        }
                    }
                } else {
                    $bootstrap = hubert()->config->bootstrap;
                    $bootstrap = new $bootstrap();
                    if($bootstrap instanceof interfaces\bootstrap){
                        $bootstrap->init();
                        $bootstraps[] = $bootstrap;
                    }
                } 
            }
            
            $response = hubert()->dispatch();
            
            foreach ($bootstraps as $bootstrap){
                $bootstrap->postDispatch($response);
            } 
            
            if($emit){
                $this->emit($response);
            }
            
            return $response;
        } catch (\Exception $exc) {
            hubert()->errorHandler->handleException($exc);
            exit();
        }
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
