<?php

namespace App\Repository;

use App\Entity\Draw;
use App\Interfaces\ICache;
use App\Interfaces\IResultApi;

class DrawApiCachingRepository implements IResultApi
{
    /** @var IResultApi */
    private $drawApiRepository;

    /** @var ICache */
    private $cacheAdapter;

    /** @var DrawDbRepositoryInterface */
    private $drawDbRepository;

    public function __construct(
        IResultApi $drawApiRepository,
        ICache $cacheAdapter,
        DrawDbRepositoryInterface $drawDbRepository
    )
    {
        $this->drawApiRepository = $drawApiRepository;
        $this->cacheAdapter = $cacheAdapter;
        $this->drawDbRepository = $drawDbRepository;
    }

    /**
     * @return Draw
     */
    public function fetch(): Draw
    {
        $cacheKey = 'fetch_one';

        if ($draw = $this->cacheAdapter->get($cacheKey)) {
            $this->drawDbRepository->save($draw);

            return $draw;
        }

        $result = $this->drawApiRepository->fetch();
        $this->cacheAdapter->put($cacheKey, $result);

        return $result;
    }
}
