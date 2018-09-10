<?php
/**
 * Created by PhpStorm.
 * User: aurelianoa
 * Date: 9/10/18
 * Time: 11:32 AM
 */

namespace src\providers;

use Exception;
use PDO;
use PHPUnit\Framework\Error\Error;

trait PDOConnector
{
    protected $pdo;
    protected $host;
    protected $database;


    private function connect()
    {
        $this->host = getenv('DB_HOST');
        $this->database = getenv('DB_DATABASE');
        try{
            $this->pdo = NEW PDO('mysql:host='.$this->host.';dbname='.$this->database, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        }
        catch (Error $e)
        {
            throw new Exception($e->getMessage());
        }

    }

}