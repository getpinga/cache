<?php

namespace Pinga\Cache\Adapter;

use Pinga\Cache\Adapter;
use Swoole\Table;
use InvalidArgumentException;

class Swoole implements Adapter
{
    /**
     * @var array<string, mixed>
     */
    protected $table;

    /**
     * Swoole constructor.
     */
    public function __construct(int $size = 1024)
    {
        $this->table = new \Swoole\Table($size);
        $this->table->column('key', \Swoole\Table::TYPE_STRING, 64);
        $this->table->column('value', \Swoole\Table::TYPE_STRING, 64);
        $this->table->create();
    }

    /**
     * @param string $key
     * @param int $ttl time in seconds
     * @return mixed
     */
    public function load(string $key, int $ttl): mixed
    {
        $this->validateKey($key);

        $value = $this->table->get($key, 'value');

        return $value !== false ? $value : null;
    }

    /**
     * @param string $key
     * @param string|array<int|string, mixed> $data
     * @return bool
     */
    public function save(string $key, $data): bool
    {
        $this->validateKey($key);

        return $this->table->set($key, ['key' => $key, 'value' => $data]);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function purge(string $key): bool
    {
        $this->validateKey($key);

        return $this->table->del($key);
    }

    /**
     * @return bool
     */
    public function flush(): bool
    {
        $result = true;

        foreach ($this->table as $key => $value) {
            if (!$this->table->del($key)) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function ping(): bool
    {
        return true;
    }

    /**
     * @param mixed $key
     */
    private function validateKey($key): void
    {
        if (!is_string($key) || $key === '' || preg_match('/[\{\}\(\)\/\\\@\:\;]/', $key)) {
            throw new InvalidArgumentException('Invalid key value.');
        }
    }
}
