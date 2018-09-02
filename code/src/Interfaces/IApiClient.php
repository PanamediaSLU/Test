<?php

namespace App\Interfaces;

use App\Exceptions\ApiErrorException;

interface IApiClient
{
    /**
     * @param $method
     * @param string $uri
     * @param array $options
     * @return array
     * @throws ApiErrorException
     */
    public function request($method, $uri = '', array $options = []): array;
}