<?php

namespace App\Repository;

use App\Entity\Draw;
use App\Exception\DatabaseException;
use App\Exception\EntityNotFoundException;

interface DrawApiRepositoryInterface
{
    /**
     * @param array $criteria
     * @param array $orderBy
     * @return Draw
     */
    public function findOneBy(array $criteria, array $orderBy = []): Draw;
}
