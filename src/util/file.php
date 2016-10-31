<?php

namespace hubert\util;

class file {
    public static function glob($pattern){
        return glob($pattern, defined('GLOB_BRACE') ? GLOB_BRACE : 0);
    }
}
