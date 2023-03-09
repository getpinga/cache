<?php

namespace Pinga\Tests;

use Pinga\Cache\Adapter\Filesystem;
use Pinga\Cache\Cache;

class FilesystemTest extends Base
{
    public static function setUpBeforeClass(): void
    {
        $path = __DIR__.'/tests/data';
        if (! file_exists($path)) {
            mkdir($path, 0777, true);
        }

        self::$cache = new Cache(new Filesystem($path));
    }

    public static function tearDownAfterClass(): void
    {
        self::$cache::setCaseSensitivity(false);
        // @phpstan-ignore-next-line
        self::$cache = null;
    }
}
