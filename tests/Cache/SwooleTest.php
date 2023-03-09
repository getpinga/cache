<?php

namespace Pinga\Tests;

use Pinga\Cache\Adapter\Swoole;
use Pinga\Cache\Cache;

class SwooleTest extends Base
{
    public static function setUpBeforeClass(): void
    {
        self::$cache = new Cache(new Swoole());
    }

    public static function tearDownAfterClass(): void
    {
        self::$cache::setCaseSensitivity(false);
        // @phpstan-ignore-next-line
        self::$cache = null;
    }
}
