<?php 

namespace App\Services;

use App\Repositories\FileCacheRepository;

class CacheService
{
    public function __construct(FileCacheRepository $cacheRepo)
    {
        $this->cacheRepo = $cacheRepo;
    }

	public function isCached($date)
	{
		return $this->cacheRepo->has($date);
	}

	public function getResult($date)
	{
		return $this->cacheRepo->get($date);
	}

	public function saveResult($date, $result)
    {
     	return $this->cacheRepo->put($date, $result);
    }
}
