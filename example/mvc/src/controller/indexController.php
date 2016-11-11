<?php

namespace src\controller;

class indexController extends \hubert\generic\controller {
    
    public function indexAction($params){
        return $this->responseTemplate("index/index", ["name" => "Hubert"]);
    }
    
    public function dbAction(){
        $users = \src\model\user::selectAll();
        
        return $this->responseTemplate("index/db", ["users" => $users]);
    }
}
