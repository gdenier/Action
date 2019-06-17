<?php


namespace Action\Core\Cache;


class CacheItem implements CacheItemInterface
{
    private $key;
    private $object;

    public function __construct()
    {
        $this->key = uniqid('cache_item');
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function get()
    {
        // TODO: Implement get() method.
    }

    public function isHit()
    {
        // TODO: Implement isHit() method.
    }

    public function set($value)
    {
        // TODO: Implement set() method.
    }

    public function expiresAt($expiration)
    {
        // TODO: Implement expiresAt() method.
    }

    public function expiresAfter($time)
    {
        // TODO: Implement expiresAfter() method.
    }
}