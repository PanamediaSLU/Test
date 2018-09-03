<?php

namespace App\Adapters;

use App\Interfaces\ICache;
use Predis\Client;

class RedisCacheAdapter implements ICache
{
    /** @var Client */
    private $redisClient;

    public function __construct($config)
    {
        $this->redisClient = new Client(
            [
                'scheme' => 'tcp',
                'host' => $config['host'],
                'port' => $config['port']
            ]
        );

        $this->redisClient->connect();
    }

    public function put($key, $json)
    {
        $this->redisClient->set($key, serialize($json));
    }

    public function get($key)
    {
        $value = unserialize($this->redisClient->get($key));

        return (false !== $value) ? $value : "";
    }

    public function flush()
    {
        $this->redisClient->flushall();
    }
}