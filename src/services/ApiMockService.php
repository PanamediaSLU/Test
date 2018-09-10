<?php
/**
 * Created by PhpStorm.
 * User: aurelianoa
 * Date: 9/10/18
 * Time: 11:20 AM
 */

namespace src\services;

use src\interfaces\IResultApi;
use src\providers\ApiConnector;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;

class ApiMockService implements IResultApi
{
    use ApiConnector;

    private function connect()
    {
        $mock = new MockHandler([new Response(200, [],json_decode(file_get_contents(__DIR__.'/../../mocks/mock.json'),true))]);
        $handler = HandlerStack::create($mock);
        $this->setUpConnectionFromHandler($handler , getenv('API_MOCK_BASE_URL'));
    }

    public function fetch()
    {

        try {
            $this->connect();
            return $this->setDraw($this->getRequestFromHandler());
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