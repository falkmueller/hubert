<?php

namespace hubert\service;

class container extends \Pimple\Container {
    
    public function __get($name){
        return $this->offsetGet($name);
    }
    
    public function __set($name, $value){
        return $this->offsetSet($name, $value);
    }
    
}
