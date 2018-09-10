<?php
/**
 * Created by PhpStorm.
 * User: aurelianoa
 * Date: 9/10/18
 * Time: 10:24 AM
 */

namespace src\providers;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Exception;


trait ApiConnector
{
    protected $client;
    protected $api_base_url;
    protected $api_key;
    protected $game;


    public function setpUpConnection($base_url,$api_key,$game){

        $this->client = new Client;
        $this->api_base_url = $base_url;
        $this->api_key = $api_key;
        $this->game = $game;
    }

    public function setUpConnectionFromHandler(HandlerStack $handler,$base_url)
    {
        $this->client = new Client(['handler' => $handler]);
        $this->api_base_url = $base_url;
    }

    public function getRequest()
    {
        return $this->client->request('GET', $this->api_base_url,
            ['query' => ['api_key' => $this->api_key,
                'game' => $this->game]]
        );
    }

    public function getRequestFromHandler()
    {
        return $this->client->request('GET', $this->base_url);
    }

    public function getGame()
    {
        return $this->game;
    }

    public function setGame($game)
    {
        $this->game = $game;
    }


    protected function throwException($message, $code = 400)
    {
        throw new Exception($message, $code);
    }
}