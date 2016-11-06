<?php

namespace hubert\interfaces;

interface bootstrap
{
    public function setContainer($container);
    public function init();
    public function postDispatch($response);
}

