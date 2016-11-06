<?php

namespace hubert\interfaces;

interface controller
{
    public function setContainer($container);
    public function setResponse($response);
    public function dispatch($action, $params);
}
