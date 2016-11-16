<?php

namespace hubert\interfaces;

interface bootstrap
{
    public function init();
    public function preDispatch();
    public function postDispatch($response);
}

