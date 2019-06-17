<?php


namespace Action\Core\Cache;


use Action\Exceptions\Cache\InvalidArgumentException;

class CacheItemPool extends \ArrayObject implements CacheItemPoolInterface
{
    private $deferred_items;

    public function __construct($input = array(), $flags = 0, $iterator_class = "ArrayIterator")
    {
        parent::__construct($input, $flags, $iterator_class);

    }

    public function getItem(string $key): CacheItem
    {
        try {
            return $this[$key];
        } catch (\OutOfBoundsException $e) {
            return new CacheItem();
        }
    }

    public function getItems(array $keys = array()): array
    {
        $items = array_map(function ($key){
            if (!is_string($key)) {
                throw new InvalidArgumentException('bad key type');
            }
            try{
                return [$key => $this[$key]];
            } catch (\Throwable $e) {}
        }, $keys);
        return $items;
    }

    public function hasItem(string $key): bool
    {
        return key_exists($key, $this);
    }

    public function clear()
    {
        $this->deleteItems(array_keys($this));
    }

    public function deleteItem(string $key): bool
    {
        try {
            unset($this[$key]);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function deleteItems(array $keys): bool
    {
        $returns = array_map(function ($key){
            if (!is_string($key)) {
                throw new InvalidArgumentException('bad key type');
            }
            try{
                $this->deleteItem($this[$key]);
                return true;
            } catch (\Throwable $e) {
                return false;
            }
        }, $keys);
        return in_array(false, $returns);
    }

    public function save(CacheItemInterface $item): bool
    {
        try{
            $this[$item->getKey()] = $item;
            return true;
        } catch(\Throwable $e) {
            return false;
        }
    }

    public function saveDeferred(CacheItemInterface $item)
    {
        try{
            $this->deferred_items[$item->getKey()] = $item;
            return true;
        } catch(\Throwable $e) {
            return false;
        }
    }

    public function commit()
    {
        array_map(function ($item) {
            $this->save($item);
        }, $this->deferred_items);
    }
}