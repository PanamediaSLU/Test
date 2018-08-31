<?php

namespace App\Repository;

use App\Entity\Draw;

interface DrawDbRepositoryInterface
{
    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param Draw $draw
     */
    public function save(Draw $draw): void;
}
