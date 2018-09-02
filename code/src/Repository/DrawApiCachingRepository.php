<?php

namespace App\Repository;

use App\Entity\Draw;
use App\Interfaces\ICache;
use App\Interfaces\IResultApi;

class DrawApiCachingRepository implements IResultApi
{
    private $drawApiRepository;
    private $cacheAdapter;

    public function __construct(
        IResultApi $drawApiRepository,
        ICache $cacheAdapter
    )
    {
        $this->drawApiRepository = $drawApiRepository;
        $this->cacheAdapter = $cacheAdapter;
    }

    /**
     * @return Draw
     */
    public function fetch(): Draw
    {
        $cacheKey = 'fetch_one';

        if ($test = $this->cacheAdapter->get($cacheKey)) {
            return json_decode($test);
        }

        $result = $this->drawApiRepository->fetch();

        $this->cacheAdapter->put($cacheKey, json_encode($result));

        return $result;
    }
}
