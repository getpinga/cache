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

use Pinga\Cache\Cache;
use Pinga\Cache\Adapter\Filesystem;

$cache  = new Cache(new Filesystem('/cache-dir'));
$key    = 'data-from-example.com';

$data   = $cache->load($key, 60 * 60 * 24 * 30 * 3 /* 3 months */);

if(!$data) {
    $data = file_get_contents('https://example.com');
    
    $cache->save($key, $data);
}

echo $data;
```

## Copyright and license

The MIT License (MIT) [http://www.opensource.org/licenses/mit-license.php](http://www.opensource.org/licenses/mit-license.php)
