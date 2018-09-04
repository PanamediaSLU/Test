<?php

namespace App\Repository;

use App\Entity\Draw;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DrawDbRepository extends EntityRepository implements DrawDbRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($entityManager, $entityManager->getClassMetadata(Draw::class));
    }

    public function delete(Draw $draw)
    {
        $this->entityManager->remove($draw);;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->entityManager->getRepository(Draw::class)->findAll();
    }

    /**
     * @param Draw $draw
     */
    public function save(Draw $draw): void
    {
        $dbDraw = $this->entityManager->getRepository(Draw::class)
        ->findOneBy( ["drawDate" =>$draw->getDrawDate()]);

        if (!$dbDraw instanceof Draw) {
            $this->entityManager->persist($draw);
            $this->entityManager->flush();
        }
    }
}
