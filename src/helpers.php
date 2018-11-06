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

function format_result($result)
{
	echo 'SORTEO DEL ' . $result['draw_date'] . ': '. $result['result_regular_number_one'] . ' ' . $result['result_regular_number_two'] . ' ' . $result['result_regular_number_three'] . ' ' . $result['result_regular_number_four'] . ' ' . $result['result_regular_number_five'] . ' ' . $result['result_lucky_number_one'] . ' ' . $result['result_lucky_number_two'] . "\n"; 
}

function is_cache_enabled()
{
	return config('cache_enable');
}