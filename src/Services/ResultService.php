<?php 

namespace App\Services;

use Carbon\Carbon;
use App\DTO\ResultDTO;
use App\Repositories\ResultApi;
use App\Repositories\ResultRepository;
use App\Repositories\FileCacheRepository;

class ResultService
{
    public function __construct(ResultApi $resultApi, ResultRepository $resultRepo, FileCacheRepository $cacheRepo)
    {
        $this->resultApi = $resultApi;

        $this->resultRepo = $resultRepo;

        $this->cacheRepo = $cacheRepo;
    }

    public function removeResult($date)
    {
        return $this->resultRepo->delete($date);
    }

    public function getLastDate($format = 'Y-m-d')
    {
        $friday = new Carbon('last friday');
        $tuesday = new Carbon('last tuesday');

        return $tuesday->greaterThan($friday) ? $tuesday->format($format) : $friday->format($format);
    }

    public function getResultFromCache()
    {
        $date = $this->getLastDate('Ymd');

        if ($this->cacheRepo->has($date)) {
            $resultJson = $this->cacheRepo->get($date);
            $result = (new ResultDTO)->setResultFromJson($resultJson)->getResult();

            return $result;
        }

        return $this->getResult();
    }

    public function getResult()
    {
        $res = $this->resultApi->fetch();

        if ($res->getStatusCode() > 200 ) {
            return $this->resultRepo->getLastResult();
        }

        $resultApi = $res->getBody()->getContents();

        $resultDTO = new ResultDTO($resultApi);
        $result    = $resultDTO->getResult();

        if ($this->resultRepo->doesNotExists($result)) {
            $this->resultRepo->create($result);
        }

        if (is_cache_enabled()) {
            $this->cacheRepo->put($result->getDrawDate('Ymd'), $resultDTO->toJson());
            // str_replace("-", "", $result->draw), 
        }

        return $result;
    }
}
