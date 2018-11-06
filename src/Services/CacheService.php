<?php 

namespace App\Services;

use App\Repositories\FileCacheRepository;

class CacheService
{
    public function __construct(FileCacheRepository $cacheRepo)
    {
        $this->cacheRepo = $cacheRepo;
    }

	public function isCached()
	{
		return $this->cacheRepo->has('draw_date');
	}

	public function getResult()
	{
		return $this->cacheRepo->get('draw_date');
	}

	public function saveResult($result)
    {
     	return $this->cacheRepo->put('draw_date', $result);
    }
}
