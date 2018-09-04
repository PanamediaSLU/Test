<?php

namespace App\Repository;

use App\Entity\Draw;

interface DrawDbRepositoryInterface
{
    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param Draw $draw
     */
    public function save(Draw $draw): void;
}
