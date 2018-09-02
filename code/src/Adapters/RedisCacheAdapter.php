<?php

namespace App\Adapters;

use App\Interfaces\ICache;
use Predis\Client;

class RedisCacheAdapter implements ICache
{
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

    public function put($key, $json): void
    {
        $this->redisClient->set($key, $json);
    }

    public function get($key): string
    {
        $this->redisClient->get($key);
    }

}