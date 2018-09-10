<?php
/**
 * Created by PhpStorm.
 * User: aurelianoa
 * Date: 9/10/18
 * Time: 3:52 PM
 */

namespace test\services;

use PHPUnit\Framework\TestCase;
use src\services\ApiService;

class ApiServiceTest extends TestCase
{
    private $apiObject;

    protected function setUp()
    {
        $this->apiObject = new ApiService;
    }
    protected function tearDown()
    {
        $this->apiObject = null;
    }


    public function testSetDrawResponse()
    {
        $apiObject = new ApiService;

        $expected = ['status' => 200, 'drawDate' => '2018-09-10', 'results' => [1, 22, 45, 34, 50, 1, 12]];

        $result = $apiObject->getLastDrawResultApi();
        $this->assertEquals($expected, $result);
    }

    public function testConnectionToApi()
    {
        $response = $this->apiObject->getRequest();
        $this->assertEquals(200, $response->getStatusCode());
    }



}