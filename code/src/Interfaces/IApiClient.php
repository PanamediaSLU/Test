<?php

namespace App\Interfaces;

use App\Adapters\ApiResultAdapter;
use App\Exceptions\ApiErrorException;

interface IApiClient
{
    /**
     * @param $method
     * @param string $uri
     * @param array $options
     * @return ApiResultAdapter
     * @throws ApiErrorException
     */
    public function request($method, $uri = '', array $options = []): IResultApi;
}