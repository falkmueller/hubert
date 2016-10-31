<?php

namespace hubert\factory;

use Zend\EventManager\EventManager;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Session\Config\StandardConfig;
use Zend\Session\SessionManager;
use Zend\Session\Container as SessionContainer;

class zend {
    
    public static function getRequest($container){
        return ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );
    }
    
    public static function getEventManager($container){
        return new EventManager();
    }
    
    public static function getSession($container){
        $config = new StandardConfig();
        $config->setOptions($container["config"]["session"]);
        $manager = new SessionManager($config);
        SessionContainer::setDefaultManager($manager);
        $manager->start();
        return function ($sessionnamespace) {
            return new SessionContainer($sessionnamespace);
        };
    }
    
    public static function getDatabaseAdapter($container){
        return new \Zend\Db\Adapter\Adapter($container["config"]["db"]);
    }
}
