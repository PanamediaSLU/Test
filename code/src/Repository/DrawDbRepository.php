<?php

namespace App\Repository;

use App\Entity\Draw;
use Doctrine\ORM\EntityManagerInterface;

class DrawDbRepository  implements DrawDbRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->findAll();
    }

    /**
     * @param Draw $draw
     */
    public function save(Draw $test): void
    {
        $this->save($draw);
    }
}
