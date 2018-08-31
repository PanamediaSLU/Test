<?php

namespace App\Adapters;

use App\Exceptions\ApiErrorException;
use App\Interfaces\IApiClient;
use App\Interfaces\IResultApi;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class GuzzleHttpClientAdapter implements IApiClient
{
    /** @var ClientInterface  */
    private $apiClient;

    public function __construct(array $config)
    {
        $this->apiClient = new Client(
            [
                'base_uri' => $config['api_url'],
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'auth' => $config['api_key']
            ]
        );
    }

    /**
     * @param $method
     * @param string $uri
     * @param array $options
     * @return ApiResultAdapter
     * @throws ApiErrorException
     */
    public function request($method, $uri = '', array $options = []): IResultApi
    {
        try {
            $response =  $this->apiClient->request($method, $uri, $options);
        } catch (GuzzleException $exception) {
            throw new ApiErrorException($exception->getMessage());
        }

        $statusCode = $response->getStatusCode();
        if ($statusCode < 200 || $statusCode >= 300) {
            throw new ApiErrorException('Bad status code', ['status_code' => $statusCode]);
        }

        return new ApiResultAdapter($response);
    }
}
