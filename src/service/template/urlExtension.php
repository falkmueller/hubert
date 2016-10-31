<?php 

namespace hubert\service\template;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class urlExtension implements ExtensionInterface {
    
    private $_container;
    
    public function setContainer($container){
        $this->_container = $container;
    }


    public function register(Engine $engine)
    {
        $engine->registerFunction('url', [$this, 'getUrl']);
        $engine->registerFunction('baseUrl', [$this, 'getBaseUrl']);
        $engine->registerFunction('current_route', [$this, 'current_route']);
    }
    
    public function getUrl($var){
        if(is_string($var)){
            return $this->_container["router"]->get($var);
        }
        elseif (is_array($var)){
            return $this->_container["router"]->get($var["name"], isset($var["params"]) ? $var["params"] : array(), isset($var["get"]) ? $var["get"] : array());
        }
        
        return "";
    }
    
    public function getBaseUrl($var = ""){
        if($var && is_string($var)){
            return $this->_container["router"]->getBasePath().$var;
        }
        
        
        return $this->_container["router"]->getBasePath();
    }
    
    public function current_route(){
        if(isset($this->_container["current_route"])){
            return $this->_container["current_route"];
        }
        
        return array("name" => "unknow");
    }
    
    
}