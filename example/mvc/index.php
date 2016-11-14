<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
//load autoloader
require_once '../../vendor/autoload.php';

//init hubert            
hubert(__dir__.'/config/');

//run and emit app
hubert()->core()->run();