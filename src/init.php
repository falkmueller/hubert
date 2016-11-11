<?php

function hubert($config = null)
{
    static $instance;
    if (!isset($instance)) {
        $instance = new hubert\hubert($config);
    }
    return $instance;
}

?>
