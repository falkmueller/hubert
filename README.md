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

### components

- PSR-7 implementation: [zendframework/zend-diactoros](https://zendframework.github.io/zend-diactoros/)
- container-dependencies: [pimple/pimple](http://pimple.sensiolabs.org/)
- router: [altorouter/altorouter] (https://github.com/dannyvankooten/AltoRouter)
- logger: [monolog/monolog](https://github.com/Seldaek/monolog)
- template engine: [league/plates](http://platesphp.com)
- event system [zendframework/zend-eventmanager](https://docs.zendframework.com/zend-eventmanager/)
- session managment [zendframework/zend-session](https://docs.zendframework.com/zend-session/)
- Database engine [zendframework/zend-db](https://docs.zendframework.com/zend-db/)

## License

The MIT License (MIT). Please see [License File](https://github.com/falkmueller/hubert/blob/master/LICENSE) for more information.