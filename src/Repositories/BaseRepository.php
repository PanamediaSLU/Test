<?php
namespace App\Repositories;
  
class BaseRepository
{

    public function __construct()
    {
        $dbParams = array(
            'driver'   => config('driver'),
            'user'     => config('user'),
            'password' => config('password'),
            'dbname'   => config('database'),
            'host'     => config('host'),
            'port'     => config('port'),
        );

        $this->db = new \mysqli(config('host'), config('user'), config('password'), config('database'), config('port'));
    }
}