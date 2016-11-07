<?php

namespace hubert\generic;

abstract class bootstrap implements \hubert\interfaces\bootstrap {
    protected $_container;
    
    public function setContainer($container){
        $this->_container = $container;
    }
    
    protected function getContainer(){
        return $this->_container;
    }
    
    public function init(){
        
    }
    
    public function postDispatch($response){

    }
}
