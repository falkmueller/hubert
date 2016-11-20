Hubert
======

[![Author](https://img.shields.io/badge/author-falkm-blue.svg?style=flat-square)](https://falk-m.de)
[![Source Code](http://img.shields.io/badge/source-falkmueller/hubert-blue.svg?style=flat-square)](https://github.com/falkmueller/hubert)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Website](https://img.shields.io/website-hubertphp.com-hubertphp.com/http/shields.io.svg)](http://hubertphp.com)

Hubert is a PHP micro framework that's fast, easy to use and easy to extend.    
For more information on how to configure your web server, see the [Documentation](http://hubertphp.com/).

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

$config = array(
    "routes" => array(
        "home" => array(
            "route" => "/", 
            "target" => function($request, $response, $args){
                echo "Hello World";
            }
        )
    )
);

hubert($config);
hubert()->core()->run();
```

### components

- PSR-7 implementation: [zendframework/zend-diactoros](https://zendframework.github.io/zend-diactoros/)
- container-dependencies: [pimple/pimple](http://pimple.sensiolabs.org/)
- router: [altorouter/altorouter] (https://github.com/dannyvankooten/AltoRouter)

## License

The MIT License (MIT). Please see [License File](https://github.com/falkmueller/hubert/blob/master/LICENSE) for more information.