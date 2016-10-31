<?php

namespace hubert\util;

class array_util {
    
    public static function merge(array $a, array $b, $preserveNumericKeys = false)
    {
        foreach ($b as $key => $value) {
            if (isset($a[$key]) || array_key_exists($key, $a)) {
                if (!$preserveNumericKeys && is_int($key)) {
                    $a[] = $value;
                } elseif (is_array($value) && is_array($a[$key])) {
                    $a[$key] = static::merge($a[$key], $value, $preserveNumericKeys);
                } else {
                    $a[$key] = $value;
                }
            } else {
               if (!$preserveNumericKeys && is_int($key)) {
                   $a[] = $value;
               } else {
                    $a[$key] = $value;
               }
            }
        }

        return $a;
    }
    
}
