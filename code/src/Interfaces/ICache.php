<?php

namespace App\Interfaces;

interface ICache
{
    public function put($key, $json);
    public function get($key);
    public function flush();
}