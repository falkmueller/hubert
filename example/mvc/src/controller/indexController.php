<?php

namespace src\controller;

class indexController extends \hubert\generic\controller {
    
    public function indexAction($params){
        return $this->responseTemplate("index/index", ["name" => "Hubert"]);
    }
    
    public function apiAction(){
        $data = ["users" => ["Falk", "Ronny"]];
        return $this->responseJson($data);
    }

    public function redirectAction(){
        $home_route = hubert()->router->get("home");
        return $this->responseRedirect($home_route);
    }
    
    public function dbAction(){
        $users = \src\model\user::selectAll();
        
        return $this->responseTemplate("index/db", ["users" => $users]);
    }
}
