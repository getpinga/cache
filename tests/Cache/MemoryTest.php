<?php

namespace Pinga\Tests;

use Pinga\Cache\Adapter\Memory;
use Pinga\Cache\Cache;

class MemoryTest extends Base
{
    public static function setUpBeforeClass(): void
    {
        self::$cache = new Cache(new Memory());
    }

    public static function tearDownAfterClass(): void
    {
        self::$cache::setCaseSensitivity(false);
        // @phpstan-ignore-next-line
        self::$cache = null;
    }
}
