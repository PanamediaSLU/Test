<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use App\Interfaces\IResultApi;

class ResultApi implements IResultApi
{
	protected $client;
	protected $apiKey;
	protected $game;

	public function __construct()
	{			
		$this->client = new Client();
		$this->apiKey = config('api_key', null);
		$this->game = 'euromillions';
		$this->apiUrl = config('api_url');
	}

    public function fetch()
    {
    	$res = $this->client->get($this->apiUrl, [
    		'query' => [
			    'api_key' => $this->apiKey,
			    'game' => $this->game,
			]
		]);

    	return json_decode($res->getBody()->getContents());
    }


}