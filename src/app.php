<?php

namespace hubert;

use Pimple\Container;

class app {
    
    private $_container;
    
    public function __construct(){
        $this->_container = new Container();
    }
    
    public function getContainer(){
        return $this->_container;
    }
    
    public function registerNamespace($name, $base_dir){
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
    
    public function loadConfig($path_or_array = null, $cachedConfigFile = null){
        $container = $this->getContainer();
        
        $config = [];

        if ($cachedConfigFile && is_file($cachedConfigFile)) {
            // Try to load the cached config
            $config = include $cachedConfigFile;
        } elseif($path_or_array) {
            $config = require __dir__.'/config.standard.php';
            
            if(is_string($path_or_array)){
                // Load container from files path
                foreach (util\file::glob($path_or_array.'{{,*.}default,{,*.}global,{,*.}local}.php') as $file) {
                    $config = util\array_util::merge($config, include $file, true);
                }
            }
            elseif(is_array($path_or_array)){
                $config = util\array_util::merge($config, $path_or_array, true);
            }
            

            if ($cachedConfigFile) {
                file_put_contents($cachedConfigFile, '<?php return ' . var_export($config, true) . ';');
            }
        } else {
            $config = require __dir__.'/config.standard.php';
        }
        
        foreach ($config['factories'] as $name => $object) {
            $container[$name] = function ($c) use ($object, $name) {
                return $object($c, $name);
            };
        }

        // Build container
        foreach ($config as $key => $value) {
            $container->offsetSet($key, $value);
        }
    }

    public function run(){
        try {
            if(!isset($this->_container["config"])){
                $this->loadConfig();
            }
            
            $bootstraps = array();
            if(isset($this->_container["config"]["bootstrap"])){
                if(is_array($this->_container["config"]["bootstrap"])){
                    foreach ($this->_container["config"]["bootstrap"] as $bootstrap_name){
                        $bootstrap = new $bootstrap_name();
                        if($bootstrap instanceof bootstrap){
                            $bootstrap->setContainer($this->_container);
                            $bootstrap->init();
                            $bootstraps[] = $bootstrap;
                        }
                    }
                } else {
                    $bootstrap = new $this->_container["config"]["bootstrap"]();
                    if($bootstrap instanceof bootstrap){
                        $bootstrap->setContainer($this->_container);
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
