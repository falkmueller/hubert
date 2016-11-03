Hubert
======

[![Author](https://img.shields.io/badge/author-falkm-blue.svg?style=flat-square)](https://falk-m.de)
[![Source Code](http://img.shields.io/badge/source-falkmueller/hubert-blue.svg?style=flat-square)](https://github.com/falkmueller/hubert)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

Hubert is a PHP micro framework that's fast, easy to use and easy to extend.

## Installation

Hubert is available via Composer:

```json
{
    "require": {
        "falkm/hubert": "1.*"
    }
}
```

## Usage

Create an index.php file with the following contents:

```php
<?php

require 'vendor/autoload.php';

$app = new hubert\app();

$config = array(
    "config" => array(
        "display_errors" => true,
    ),
    "routes" => array(
        "home" => array(
            "route" => "/", 
            "method" => "GET|POST", 
            "target" => function($request, $response, $args){
                echo "Hello World";
            }
        )
    )
);

$app->loadConfig($config);
$app->emit($app->run());
```

### components

- PSR-7 implementation: [zendframework/zend-diactoros](https://zendframework.github.io/zend-diactoros/)
- container-dependencies: [pimple/pimple](http://pimple.sensiolabs.org/)
- router: [altorouter/altorouter] (https://github.com/dannyvankooten/AltoRouter)

## License

The MIT License (MIT). Please see [License File](https://github.com/falkmueller/hubert/blob/master/LICENSE) for more information.