<?php

namespace App\Repository;

use App\Entity\Draw;
use App\Exceptions\NotFoundException;

class DrawFallbackApiRepository implements DrawApiRepositoryInterface
{
    public function __construct()
    {
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @return Draw
     */
    public function findOneBy(array $criteria, array $orderBy = []): Draw
    {
        if (isset($criteria['game']) && $criteria['game'] == 'euromillions')
            return new Draw(1,
            1,
            "01/01/2018",
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9);
    }
}



