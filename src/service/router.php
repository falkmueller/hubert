<?php

namespace hubert\service;

class router extends \AltoRouter implements \hubert\interfaces\router {
    
    public static function factory($container){
        $ServerParams = $container["request"]->getServerParams(); 
        $basePath = (dirname($ServerParams['SCRIPT_NAME']) != '/' ? dirname($ServerParams["SCRIPT_NAME"]): ''); 
        return new static($basePath); 
    }
    
    function __construct($basePath) {
        parent::__construct(array(),$basePath, array());
    }
    
    public function get($routeName, array $params = array(), array $get_params = array()) {
        $url = parent::generate($routeName, $params);
        
        if(count($get_params) > 0){
            $url .= "?";
            $query_params = array();
            foreach($get_params as $key => $value){
                $query_params[] = $key.'='.urlencode($value);
            }

            $url .= implode("&", $query_params);
        }
        
        return $url;
    }
    
    public function add($routeName, $route, $target, $method = 'GET|POST'){
        parent::map($method, $route, $target, $routeName);
    }  
    
    public function getBasePath() {
        return $this->basePath;
    }
}

