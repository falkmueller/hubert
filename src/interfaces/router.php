<?php

namespace hubert\interfaces;

interface router
{
    public function __construct($basePath);
    public function add($routeName, $route, $target, $method = 'GET|POST');
    public function get($routeName, array $params = array(), array $get_params = array());
    public function match($requestUrl, $requestMethod);  
    public function getBasePath();
}
