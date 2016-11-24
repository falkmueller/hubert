<?php

function hubert($config = null, $cache_file = null)
{
    static $instance;
    if (!isset($instance)) {
        $instance = new hubert\hubert($config, $cache_file);
    }
    return $instance;
}

?>
