<?php

namespace App\Repository;

use App\Entity\Draw;
use App\Interfaces\ICache;

class DrawApiCachingRepository implements DrawApiRepositoryInterface
{
    private $testApiRepository;
    private $cacheAdapter;

    public function __construct(DrawApiRepositoryInterface $testApiRepository, ICache $cacheAdapter)
    {
        $this->testApiRepository = $testApiRepository;
        $this->cacheAdapter = $cacheAdapter;
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @return Draw
     * @throws \App\Exceptions\NotFoundException
     */
    public function findOneBy(array $criteria, array $orderBy = []): Draw
    {
        $cacheKey = 'find_by_' . implode("_", $criteria);

        if ($test = $this->cacheAdapter->get($cacheKey)) {
            return json_decode($test);
        }

        $result = $this->testApiRepository->findOneBy($criteria, $orderBy);

        $this->cacheAdapter->put($cacheKey, json_encode($result));

        return $result;
    }
}
