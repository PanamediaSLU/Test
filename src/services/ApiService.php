<?php
/**
 * Created by PhpStorm.
 * User: aurelianoa
 * Date: 9/10/18
 * Time: 10:05 AM
 */

namespace src\services;

use src\interfaces\IResultApi;
use src\providers\ApiConnector;
use GuzzleHttp\Exception\ClientException;

class ApiService implements IResultApi
{
    use ApiConnector;

    private function connect()
    {
        $this->setpUpConnection(getenv('API_BASE_URL'),getenv('API_KEY'),getenv('API_GAME'));
    }

    public function fetch()
    {

        try {
            $this->connect();
            return $this->setDraw($this->getRequest());
        } catch (ClientException $e) {
            $this->throwException(sprintf('Failed to get data'));
        }
    }

    protected function setDraw($response)
    {
        $arr['status'] = $response->getStatusCode();
        if($arr['status'] == 200)
        {
            $data = json_decode($response->getBody());
            if($data->error == 0)
            {
                foreach(explode(',',$data->results) as $item => $value)
                {
                    $arr['results'][]=$value;
                }
                $arr['drawDate']=$data->draw;
            }
            else{
                $this->throwException(sprintf($response->getBody()));
            }
        }
        else{
            $this->throwException(sprintf($response->getBody()));
        }
        return $arr;
    }
}