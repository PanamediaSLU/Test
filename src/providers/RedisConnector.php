<?php
/**
 * Created by PhpStorm.
 * User: aurelianoa
 * Date: 9/10/18
 * Time: 11:46 AM
 */

namespace src\providers;
use Predis\Client;
use Exception;

trait RedisConnector
{
    private $redis;
    public function __construct()
    {
        try
        {
            $this->redis = new Client();
        }
        catch(\Exception $e)
        {
            throw new RedisException($e->getMessage());
        }
    }
    public function put($key, $json)
    {
        try
        {
            $this->redis->set($key, $json);
        }
        catch(\Exception $e)
        {
            throw new RedisException($e->getMessage());
        }
    }
    public function get($key)
    {
        try
        {
            $aux = $this->redis->get($key);
        }
        catch(\Exception $e)
        {
            throw new Exception($e->getMessage());
        }
        return (array)json_decode($aux);
    }
}