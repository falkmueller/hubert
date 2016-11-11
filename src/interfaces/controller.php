<?php

namespace hubert\interfaces;

interface controller
{
    public function setResponse($response);
    public function dispatch($action, $params);
}
