<?php

namespace App\Adapters;

use App\Interfaces\IResultApi;
use Psr\Http\Message\ResponseInterface;

class ApiResultAdapter implements IResultApi
{
    private $apiResponse;

    public function __construct(ResponseInterface $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }

    public function fetch()
    {
        return json_decode($this->apiResponse->getBody(), true);
    }
}