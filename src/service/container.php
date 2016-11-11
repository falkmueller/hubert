<?php

namespace hubert\service;

class container extends \Pimple\Container {
    
    public function __get($name){
        return $this->offsetGet($name);
    }
    
    public function __set($name, $value){
        return $this->offsetSet($name, $value);
    }
    
    public function __call($method, $args)
    {
        if ($this->offsetExists($method)) {
            $obj = $this->offsetGet($method);
            if (is_callable($obj)) {
                return call_user_func_array($obj, $args);
            }
        }
        throw new \BadMethodCallException("Method $method is not a valid method");
    }
    
    public function __isset ($name){
        return $this->offsetExists($name);
    }
    
}
