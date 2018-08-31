<?php

namespace App\Adapters;

use App\Interfaces\ICache;
use Symfony\Component\Cache\Simple\RedisCache;

class RedisCacheAdapter implements ICache
{
    private $redisClient;

    public function __construct(RedisCache $redisClient)
    {
        $this->redisClient = $redisClient;
    }

    public function put($key, $json): void
    {
        $this->redisClient->set($key, $json);
    }

    public function get($key): json
    {
        $this->redisClient->get($key);
    }

}