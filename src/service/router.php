<?php

namespace hubert\service;

class router extends \AltoRouter implements \hubert\interfaces\router {
    
    function __construct($basePath) {
        parent::__construct(array(),$basePath, array());
    }
    
    public function get($routeName, array $params = array(), array $get_params = array()) {
        $url = parent::generate($routeName, $params);
        
        if(count($get_params) > 0){
            $url .= "?";
            $query_params = array();
            foreach($params as $key => $value){
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

