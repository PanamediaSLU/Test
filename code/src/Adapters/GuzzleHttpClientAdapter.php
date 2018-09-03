<?php

namespace App\Adapters;

use App\Exceptions\ApiErrorException;
use App\Interfaces\IApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class GuzzleHttpClientAdapter implements IApiClient
{
    /** @var ClientInterface  */
    private $apiClient;

    /** @var string */
    private $apiKey;

    public function __construct(array $config)
    {
        $this->apiClient = new Client(
            [
                'base_uri' => $config['api_url'],
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]
        );

        $this->apiKey = $config['api_key'];
    }

    /**
     * @param $method
     * @param string $uri
     * @param array $options
     * @return array
     * @throws ApiErrorException
     */
    public function request($method, $uri = '', array $options = []): array
    {
        if(!isset($options['query']) || !is_array($options['query'])){
            $options['query'] = [];
        }

        $options['query'] = array_merge($options['query'], ["api_key" => $this->apiKey]);

        try {
            $response =  $this->apiClient->request($method, $uri, $options);
        } catch (GuzzleException $exception) {
            throw new ApiErrorException($exception->getMessage());
        }

        $statusCode = $response->getStatusCode();
        if ($statusCode < 200 || $statusCode >= 300) {
            throw new ApiErrorException('Bad status code', ['status_code' => $statusCode]);
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}
