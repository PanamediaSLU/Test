<?php
namespace App\Repositories;
  
class BaseRepository
{

    public function __construct()
    {
       $this->db = new \mysqli(config('host'), config('user'), config('password'), config('database'), config('port'));
    }
}