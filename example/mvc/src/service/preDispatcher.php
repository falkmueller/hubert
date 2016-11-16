<?php

namespace src\service;

class preDispatcher {

    public static function get($container){
        return array(new static(), 'preDispatch');
    }

    public function preDispatch(){
        //do something
    }
}
