<?php

namespace App\Repository;

use App\Entity\Draw;
use Doctrine\ORM\EntityManagerInterface;

class DrawDbRepository implements DrawDbRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return [$this->entityManager->find(Draw::class, 1)];
    }

    /**
     * @param Draw $draw
     */
    public function save(Draw $draw): void
    {
        $this->entityManager->persist($draw);
        $this->entityManager->flush();
    }
}
