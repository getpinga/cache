<?php

namespace Pinga\Tests;

use Redis as Redis;
use Throwable;
use Pinga\Cache\Adapter\Redis as RedisAdapter;
use Pinga\Cache\Adapter\Sharding;
use Pinga\Cache\Cache;

class ShardingTest extends Base
{
    public static function setUpBeforeClass(): void
    {
        $shardA = new Redis();
        $shardA->connect('shardA', 6379);

        $shardB = new Redis();
        $shardB->connect('shardB', 6379);

        $shardC = new Redis();
        $shardC->connect('shardC', 6379);

        self::$cache = new Cache(new Sharding([
            new RedisAdapter($shardA),
            new RedisAdapter($shardB),
            new RedisAdapter($shardC),
        ]));
    }

    public static function tearDownAfterClass(): void
    {
        self::$cache::setCaseSensitivity(false);
        // @phpstan-ignore-next-line
        self::$cache = null;
    }

    public function testEmptyAdapters(): void
    {
        $this->expectException(Throwable::class);

        self::$cache = new Cache(new Sharding([]));
    }
}
