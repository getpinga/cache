<?php

namespace Utopia\Cache\Adapter;

use Utopia\Cache\Adapter;
use Swoole\Table;

class Swoole implements Adapter
{
    /**
     * @var array<string, mixed>
     */
    public $store = [];
    protected $table;

    /**
     * Swoole constructor.
     */
    public function __construct($size = 1024)
    {
        $this->table = new \Swoole\Table($size);
        $this->table->column('key', \Swoole\Table::TYPE_STRING, 64);
        $this->table->column('value', \Swoole\Table::TYPE_STRING, 64);
        $this->table->create();
    }

    /**
     * @param  string  $key
     * @return string
     */
    public function load(string $key, mixed $default = null): string
    {
        $this->validateKey($key);
        $key = $this->table->get($key, 'value');
        
        if ($key == null) {
            return $default;
        }

        return $key;
    }

    /**
     * @param  string  $key
     * @param  string|array<int|string, mixed>  $data
     * @return bool|string|array<int|string, mixed>
     */
    public function save(string $key, string $value, $ttl = null): bool
    {
        $this->validateKey($key);
        return $this->table->set($key, ['key'=>$key,'value'=>$value]);
    }

    /**
     * @param  string  $key
     * @return bool
     */
    public function purge(string $key):bool
    {
        $this->validateKey($key);
        return $this->table->del($key);
    }

    /**
     * @return bool
     */
    public function flush() : bool
    {
        $flag = false;
        foreach ($this->table as $k => $item) {
            $flag = $this->table->del($k);
            if (!$flag) {
                return false;
            }
        }
        return true;
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
        if (!is_string($key) || $key === '' || strpbrk($key, '{}()/\@:')) {
            throw new InvalidArgumentException('Invalid key value.');
        }
    }
}
