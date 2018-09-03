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
    private $drawDbRepository;

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
        $this->drawDbRepository = $this->entityManager->getRepository(Draw::class);
        $this->cacheAdapter = $kernel->getContainer()->get(RedisCacheAdapter::class);

        $this->resetDbAndCache();
    }

    public function testApiResultIsReturnedAndSavedToDb()
    {
        $this->resetDbAndCache();
        $allItems = $this->drawDbRepository->findAll();
        $draw = $this->useCase->execute();
        $allItemsAfterUseCase = $this->drawDbRepository->findAll();
        $this->assertInstanceOf(Draw::class, $draw);
        $this->assertSame(count($allItems) + 1, count($allItemsAfterUseCase),
            'Amount of security systems is not the same');
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
        $qb = $this->drawDbRepository->createQueryBuilder("qb");

        $qb->delete(Draw::class, 'io');
        $qb->where('io.id >= :id');
        $qb->setParameter(':id', 1);
        $qb->getQuery()->execute();

        $this->cacheAdapter->flush();
    }
}