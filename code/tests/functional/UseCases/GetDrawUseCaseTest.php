<?php

namespace App\Tests\functional\UseCases;

use App\Adapters\RedisCacheAdapter;
use App\Entity\Draw;
use App\Interfaces\ICache;
use App\Interfaces\IResultApi;
use App\UseCases\GetDrawUseCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GetDrawUseCaseTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /** @var GetDrawUseCase */
    private $useCase;

    /** @var IResultApi */
    private $drawRepository;

    /** @var ICache */
    private $cacheAdapter;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->useCase = $kernel->getContainer()->get(GetDrawUseCase::class);
        $this->drawRepository = $this->entityManager->getRepository(Draw::class);
        $this->cacheAdapter = $kernel->getContainer()->get(RedisCacheAdapter::class);

        $this->resetDbAndCache();
    }

    public function testApiResultIsReturnedAndSavedToDbOnFirstCall()
    {
        $allItems = $this->drawRepository->findAll();
        $draw = $this->useCase->execute();
        $allItemsAfterUseCase = $this->drawRepository->findAll();
        $this->assertInstanceOf(Draw::class, $draw);
        $this->assertSame(count($allItems) + 1, count($allItemsAfterUseCase),
            'Amount of security systems is not the same');
    }

    public function testApiResultIsReturnedOnSubsequentCalls()
    {
        $draw = $this->useCase->execute();
        $this->assertInstanceOf(Draw::class, $draw);

        $draw = $this->useCase->execute();
        $this->assertInstanceOf(Draw::class, $draw);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }

    private function resetDbAndCache()
    {
        $qb = $this->drawRepository->createQueryBuilder("qb");

        $qb->delete(Draw::class, 'io');
        $qb->where('io.id >= :id');
        $qb->setParameter(':id', 1);
        $qb->getQuery()->execute();

        $this->cacheAdapter->flush();
    }
}