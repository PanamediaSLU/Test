<?php

namespace src\interfaces;

interface ICache
{
    public function put($key, $json);
    public function get($key);
}