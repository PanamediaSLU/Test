<?php

namespace App\Adapters;

use App\Interfaces\IResultApi;
use GuzzleHttp\Psr7\Response;

class GuzzleHttpResponseAdapter implements IResultApi
{
    private $apiResponse;

    /**
     * ApiResponseAdapter constructor.
     * @param $apiResponse
     */
    public function __construct(Response $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }

    public function fetch()
    {
        return $this->apiResponse->getBody();
    }
}