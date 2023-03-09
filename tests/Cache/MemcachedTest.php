<?php

namespace Pinga\Tests;

use Memcached as Memcached;
use Pinga\Cache\Adapter\Memcached as MemcachedAdapter;
use Pinga\Cache\Cache;

class MemcachedTest extends Base
{
    public static function setUpBeforeClass(): void
    {
        $mc = new Memcached();
        $mc->addServer('memcached', 11211);

        self::$cache = new Cache(new MemcachedAdapter($mc));
    }

    public static function tearDownAfterClass(): void
    {
        self::$cache::setCaseSensitivity(false);
        // @phpstan-ignore-next-line
        self::$cache = null;
    }
}
