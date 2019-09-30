<?php

function config($key, $default = null)
{
    $config = parse_ini_file(__DIR__ . "/../config.ini");

    if (isset($config[$key])) {
        return $config[$key];
    }

    return $default ?: '';
}

function is_valid_date($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);

    return $d && $d->format($format) === $date;
}

function is_cache_enabled()
{
	return config('cache_enable');
}