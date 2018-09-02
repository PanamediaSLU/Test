<?php

namespace App\Tests\functional\UseCases;

use App\Entity\Draw;
use App\UseCases\GetDrawUseCase;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GetDrawUseCaseTest  extends KernelTestCase
{
    public function testUseCase()
    {
        self::bootKernel();

        /** @var GetDrawUseCase $command */
        $useCase = self::$kernel->getContainer()
            ->get("App\UseCases\GetDrawUseCase");


        /** @var EntityManagerInterface $em */
        $em = self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        /** @var EntityRepository $repository */
        $repository = $em->getRepository("App\Entity\Draw");

        $qb =  $repository->createQueryBuilder("qb");

        $qb->delete(Draw::class, 'io');
        $qb->where('io.id >= :id');
        $qb->setParameter(':id', 1);
        $qb->getQuery()->execute();


        $allItems = $repository->findAll();

        $useCase->execute();

        $allItemsAfterUseCase = $repository ->findAll();

        $this->assertSame(count($allItems)+1, count($allItemsAfterUseCase), 'Amount of security systems is not the same');
    }
}