<?php

namespace App\Tests\functional\UseCases;

use App\UseCases\GetDrawUseCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GetDrawUseCaseTest  extends KernelTestCase
{
    public function testUseCase()
    {
        self::bootKernel();

        /** @var GetDrawUseCase $command */
        $useCase = self::$kernel->getContainer()
            ->get("App\UseCases\GetDrawUseCase");


        $em = self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $allItems = $em->getRepository(Test::class)
            ->findAll();

        $useCase->execute();

        $allItemsAfterUseCase = $em->getRepository(Test::class)
            ->findAll();

        $this->assertSame(count($allItems)+1, $allItemsAfterUseCase, 'Amount of security systems is not the same');
    }
}