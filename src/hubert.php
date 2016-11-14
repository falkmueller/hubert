<?php

namespace hubert;

class hubert extends \Pimple\Container {
    
    public function __construct($config_path_or_file_or_array = null, $config_cache_file = null){
        parent::__construct();
        $this->loadConfig($config_path_or_file_or_array, $config_cache_file);
    }
    
    public function __get($name){
        return $this->offsetGet($name);
    }
    
    public function __set($name, $value){
        return $this->offsetSet($name, $value);
    }
    
    public function __call($method, $args)
    {
        if ($this->offsetExists($method)) {
            $obj = $this->offsetGet($method);
            if (is_callable($obj)) {
                return call_user_func_array($obj, $args);
            }else {
                return $obj;
            }
        }
        throw new \BadMethodCallException("Method $method is not a valid method");
    }
    
    public function __isset ($name){
        return $this->offsetExists($name);
    }
    
    private function loadConfig($config_path_or_file_or_array = null, $config_cache_file = null){
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
            $this[$name] = function ($c) use ($object, $name) {
                return $object($c, $name);
            };
        }
        
        //load routes
        if(isset($config["routes"])){
            $routes = $config["routes"];
            if(is_array($routes) && count($routes) > 0){
                foreach ($routes as $route_name => $route){
                    $this["router"]->add($route_name, $route["route"], $route["target"], (isset($route["method"]) ? $route["method"] : "GET|POST"));
                }
            }
        }
        
        //set configuration
        $this["config"] = new service\config($config['config']);
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
}
