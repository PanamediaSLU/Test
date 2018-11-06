<?php

use PHPUnit\Framework\TestCase;
use App\Services\ResultService;

class AppTest extends TestCase
{
    public function test_valid_api_url()
    {
        $this->assertSame(config('api_url'), 'http://www.magayo.com/api/results.php');
    }

    public function test_api_no_errrs()
    {
    	$api = new App\Repositories\ResultApi;
    	$result = $api->fetch();

  	  	$this->assertSame($result->error, 0);	
    }

    public function test_api_draw_is_date()
    {
    	$api = new App\Repositories\ResultApi;
    	$result = $api->fetch();

  	  	$this->assertSame(is_valid_date($result->draw), true);
    }

    public function test_api_result_has_7_numbers()
    {
    	$api = new App\Repositories\ResultApi;
    	$result = $api->fetch();

    	$numbers = explode(',', $result->results);
    	$total = count($numbers);

  	  	$this->assertSame($total, 7);
    }
}
