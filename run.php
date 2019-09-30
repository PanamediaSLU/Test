<?php

use App\DTO\ResultDTO;
use App\Entities\Result;
use PHPUnit\Framework\TestCase;
use App\Services\ResultService;
use App\Repositories\ResultRepository;
use App\Repositories\FileCacheRepository;

class AppTest extends TestCase
{
    protected $date = '19900706';
    
    protected $data = [
        'draw_date' => '1990-07-06',
        'result_regular_number_one' => '10',
        'result_regular_number_two' => '20',
        'result_regular_number_three' => '30',
        'result_regular_number_four' => '40',
        'result_regular_number_five' => '50',
        'result_lucky_number_one' => '01',
        'result_lucky_number_two' => '02',
    ];

    public function test_valid_api_url()
    {
        $this->assertSame(config('api_url'), 'http://www.magayo.com/api/results.php');
    }

    public function test_cache()
    {
        $resultDTO = new ResultDTO($this->data);
        $resultJson = $resultDTO->toJson();
        $cacheRepo = new FileCacheRepository();
        $cacheRepo->put($resultDTO->getDrawDate('Ymd'), $resultJson);

        $this->assertSame($cacheRepo->has($resultDTO->getDrawDate('Ymd')), true);

        $resultJson2 = $cacheRepo->get($this->date);
        $resultDTO2 = new ResultDTO();
        $result2 = $resultDTO2->setResultFromJson($resultJson2)->getResult();
    	
        $isInstance = $result2 instanceof Result;
        $this->assertSame($isInstance, true);
    }

    public function test_dto()
    {
        $resultDTO = new ResultDTO();
        $resultDTO->setResultFromArray($this->data);
        $result = $resultDTO->getResult();

        $isInstance = $result instanceof Result;
        $this->assertSame($isInstance, true);
        $this->assertSame($result->getDrawDate('Ymd'), $this->date);

        $resultDTO2 = new ResultDTO();
        $resultDTO2->setResultFromJson(json_encode($this->data));
        $result2 = $resultDTO2->getResult();

        $isInstance2 = $result2 instanceof Result;
        $this->assertSame($isInstance2, true);
        $this->assertSame($result2->getDrawDate('Ymd'), $this->date);
        $this->assertSame($resultDTO2->toArray(), $this->data);
        $this->assertSame($result->getResultLuckyNumberOne(), $result2->getResultLuckyNumberOne());

        $resultDTO3 = new ResultDTO();

        $api = json_decode(json_encode([
            "draw" => "1990-07-06",
            "results" => "10,20,30,40,50,01,02"
        ]));

        $resultDTO3->setResultFromApi(json_encode($api));
        $result3 = $resultDTO3->getResult();

        $isInstance3 = $result3 instanceof Result;
        $this->assertSame($isInstance3, true);
        $this->assertSame($result3->getDrawDate('Ymd'), $this->date);
        $this->assertSame($resultDTO3->toArray(), $this->data);
        $this->assertSame($result->getResultLuckyNumberOne(), $result3->getResultLuckyNumberOne());
    }

    public function test_repository()
    {
        $resultDTO = new ResultDTO($this->data);
        $result = $resultDTO->getResult();

        $resultRepo = new ResultRepository;
        $resultRepo->create($result);

        $exists1 = $resultRepo->exists($result);
        $exists2 = $resultRepo->exists($result->getDrawDate());

        $this->assertSame($exists1, true);
        $this->assertSame($exists2, true);

        $result2 = $resultRepo->find($result->getDrawDate());

        $this->assertSame($result->getDrawDate(), $result2->getDrawDate());

        $resultRepo->delete($result);

        $exists3 = $resultRepo->exists($result);

        $this->assertSame($exists3, false);
    }
}
