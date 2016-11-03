<?php

namespace app;

class bootstrap extends \hubert\bootstrap{
    
    public function preDispatch(){
        //set Shared Data vor all Templates
        //$this->_container["template"]->addData(array("name" => "ronny"));

    }
    
   
    
}
