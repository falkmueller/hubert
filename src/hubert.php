<?php

namespace hubert;

use Pimple\Container;

class hubert {
    
    private $_container;
    private $_config;
    
    public function __construct($config_path_or_file_or_array = null, $config_cache_file = null){
        $this->_container = new service\container();
        $this->loadConfig($config_path_or_file_or_array, $config_cache_file);
    }
    
    public function container(){
        return $this->_container;
    }
    
    public function config(){
       return $this->_config; 
    }

    private function loadConfig($config_path_or_file_or_array = null, $config_cache_file = null){
        $container = $this->container();
        
        if($config_cache_file && is_file($config_cache_file)){
            $config = require $config_cache_file;
        } else {
            $config = require __dir__.'/config.standard.php';

            if(is_array($config_path_or_file_or_array)) {    
                $config = util\array_util::merge($config, $config_path_or_file_or_array, true);
            }
            elseif (is_file($config_path_or_file_or_array)) {
                // Try to load the cached config
                $config = util\array_util::merge($config, include $config_path_or_file_or_array, true);
            } 
            elseif(is_dir($config_path_or_file_or_array)) {
                foreach (util\file::glob($config_path_or_file_or_array.'{{,*.}default,{,*.}global,{,*.}local}.php') as $file) {
                    $config = util\array_util::merge($config, include $file, true);
                }
            }
            
            if($config_cache_file){
                file_put_contents($config_cache_file, '<?php return ' . var_export($config, true) . ';');
            }
        }
        
        //load aoutoloader
        if(isset($config['namespace'])){
            foreach ($config['namespace'] as $name => $dir) {
                $this->registerNamespace($name, $dir);
            }
        }

        //load factories
        foreach ($config['factories'] as $name => $object) {
            $container[$name] = function ($c) use ($object, $name) {
                return $object($c, $name);
            };
        }
        
        //load routes
        if(isset($config["routes"])){
            $routes = $config["routes"];
            if(is_array($routes) && count($routes) > 0){
                foreach ($routes as $route_name => $route){
                    $container["router"]->add($route_name, $route["route"], $route["target"], (isset($route["method"]) ? $route["method"] : "GET|POST"));
                }
            }
        }
        
        //set configuration
        $this->_config = new service\config($config['config']);
    }
    
    private function registerNamespace($name, $base_dir){
        spl_autoload_register(function ($class) use($name, $base_dir) {

            // project-specific namespace prefix
            $prefix = $name.'\\';

            // does the class use the namespace prefix?
            $len = strlen($prefix);
            if (strncmp($prefix, $class, $len) !== 0) {
                // no, move to the next registered autoloader
                return;
            }

            // get the relative class name
            $relative_class = substr($class, $len);

            // replace the namespace prefix with the base directory, replace namespace
            // separators with directory separators in the relative class name, append
            // with .php
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

            if (file_exists($file)) {
                require $file;
            }
        });
    }

    public function run(){
        try {
            if(!isset($this->_config)){
                $this->loadConfig();
            }
            
            $bootstraps = array();
            if(isset($this->_config["bootstrap"])){
                if(is_array($this->_config["bootstrap"])){
                    foreach ($this->_config["bootstrap"] as $bootstrap_name){
                        $bootstrap = new $bootstrap_name();
                        if($bootstrap instanceof interfaces\bootstrap){
                            $bootstrap->init();
                            $bootstraps[] = $bootstrap;
                        }
                    }
                } else {
                    $bootstrap = new $this->_config["bootstrap"]();
                    if($bootstrap instanceof interfaces\bootstrap){
                        $bootstrap->init();
                        $bootstraps[] = $bootstrap;
                    }
                } 
            }
            
            $response = $this->_container["dispatch"]();
            
            foreach ($bootstraps as $bootstrap){
                $bootstrap->postDispatch($response);
            } 
            
            return $response;
        } catch (\Exception $exc) {
            $this->_container["exceptionHandler"]($exc);
            exit();
        }
    }
    
    public function emit($response){
        if($response && $response instanceof \Zend\Diactoros\Response){
            $emitter = new \Zend\Diactoros\Response\SapiEmitter();
            $emitter->emit($response);
        } elseif (is_string($response)){
            echo $response;
        }   
    }
    
    
}
