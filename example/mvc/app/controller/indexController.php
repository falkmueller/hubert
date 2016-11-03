<?php

namespace app\controller;

class indexController extends \hubert\controller {
    
    public function indexAction($params){
        return $this->responseTemplate("index/index", ["name" => "Hubert"]);
    }
    
    public function dbAction(){
        $userTable = new \app\model\table\user($this->getContainer());
        $users = $userTable->fetchAll();
        
        return $this->responseTemplate("index/db", ["users" => $users]);
    }
}
