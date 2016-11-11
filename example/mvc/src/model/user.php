<?php

namespace src\model;

class user extends \hubert\extension\db\model {
    
     protected static $table = "users";
     
     public static function fields(){
        return array(
            "id" => array('type' => 'integer', 'primary' => true, 'autoincrement' => true),
            "name" => array('type' => 'string', "default" => ""),
        );
    }
}
