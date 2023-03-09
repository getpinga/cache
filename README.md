# Pinga Cache

**Based on wonderful [utopia-cache](https://github.com/utopia-php/cache) and [scrawler-labs/swoole-cache](https://github.com/scrawler-labs/swoole-cache)**

## Getting Started

Install using composer:
```bash
composer require pinga/cache
```

**File System Adapter**

```php
<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Utopia\Cache\Cache;
use Utopia\Cache\Adapter\Filesystem;

$cache  = new Cache(new Filesystem('/cache-dir'));
$key    = 'data-from-example.com';

$data   = $cache->load($key, 60 * 60 * 24 * 30 * 3 /* 3 months */);

if(!$data) {
    $data = file_get_contents('https://example.com');
    
    $cache->save($key, $data);
}

echo $data;
```

## Contribute

Currently we support only a Filesystem adapter for usage as a cache storage, send a pull request to add redis, memcached or any other storage adapter you might need to use with this library.

## System Requirements

Utopia Framework requires PHP 8.0 or later. We recommend using the latest PHP version whenever possible.

## Tests

To run all unit tests, use the following Docker command:

`docker-compose exec php8 vendor/bin/phpunit --configuration phpunit.xml tests`

To run static code analysis, use the following Psalm command:

`docker-compose exec php8 vendor/bin/psalm --show-info=true`


## Copyright and license

The MIT License (MIT) [http://www.opensource.org/licenses/mit-license.php](http://www.opensource.org/licenses/mit-license.php)
