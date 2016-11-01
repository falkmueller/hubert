<?php

namespace app\controller;

class indexController extends \hubert\controller {
    
    public function indexAction($params){
        
        return $this->responseTemplate("index", array("name" => "Falk"));
    }
}
