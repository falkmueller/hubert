<?php

namespace hubert\service;

class config implements \ArrayAccess {
    
    private $config;
    
    public function __construct($config = array()){
        $this->config = $config;
    }
    
     public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->config[] = $value;
        } else {
            $this->config[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->config[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->config[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->config[$offset]) ? $this->config[$offset] : null;
    }
    
    public function __isset ($name){
        return $this->offsetExists($name);
    }
    
    public function __unset ($name){
        return $this->offsetUnset($name);
    }
    
    public function __get($name){
        return $this->offsetGet($name);
    }
    
    public function __set($name, $value){
        return $this->offsetSet($name, $value);
    }
    
    public function __call($method, $args)
    {
         return $this->offsetGet($method);
    }
    
}
