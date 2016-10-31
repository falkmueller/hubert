<?php

namespace hubert;

class bootstrap {
    protected $_container;
    
    public function setContainer($container){
        $this->_container = $container;
    }
    
    public function preDispatch(){
        
    }
    
    public function postDispatch($response){

    }
}
