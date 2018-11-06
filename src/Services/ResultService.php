<?php 

namespace App\Services;

use App\Repositories\ResultApi;
use App\Repositories\ResultRepository;

class ResultService
{
    public function __construct(ResultApi $resultApi, ResultRepository $resultRepo)
    {
        $this->resultApi = $resultApi;

        $this->resultRepo = $resultRepo;
    }

	public function getFromApi()
	{
		return $this->resultApi->fetch();
	}

	public function getFromDB($date)
	{
		return $this->resultRepo->find($date);
	}

	public function saveResult($result)
    {
        $numbers = explode(',', $result->results);

        $data = [];
        $data['name'] = '';
        $data['loteryId'] = '';
        $data['drawDate'] = $result->draw;
        $data['resultRegularNumberOne'] = $numbers[0];
        $data['resultRegularNumberTwo'] = $numbers[1];
        $data['resultRegularNumberThree'] = $numbers[2];
        $data['resultRegularNumberFour'] = $numbers[3];
        $data['resultRegularNumberFive'] = $numbers[4];
        $data['resultLuckyNumberOne'] = $numbers[5];
        $data['resultLuckyNumberTwo'] = $numbers[6];
        $data['jackpotAmount'] = '';
        $data['jackpotCurrencyName'] = '';
 
        return $this->resultRepo->create($data);
    }

    public function isInDB($date)
    {
    	return $this->resultRepo->exists($date);
    }

    public function removeResult($date)
    {
        return $this->resultRepo->delete($date);
    }
}
