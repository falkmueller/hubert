<?php

namespace hubert\interfaces;

interface bootstrap
{
    public function init();
    public function postDispatch($response);
}

