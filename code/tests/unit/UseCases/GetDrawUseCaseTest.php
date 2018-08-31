<?php

namespace App\Tests\unit\UseCases;

use App\Entity\Draw;
use App\Repository\DrawApiRepositoryInterface;
use App\Repository\DrawDbRepositoryInterface;
use App\UseCases\GetDrawUseCase;
use PHPUnit\Framework\TestCase;

class GetDrawUseCaseTest extends TestCase
{
    /** @var GetDrawUseCase */
    private $useCase;

    /** @var DrawApiRepositoryInterface */
    private $testApiRepositoryMock;

    /** @var DrawApiRepositoryInterface */
    private $testFallbackApiRepositoryMock;

    /** @var DrawDbRepositoryInterface */
    private $testDbRepositoryMock;

    protected function setup()
    {
        $this->testApiRepositoryMock =  $this->prophesize(\App\Repository\DrawApiRepository::class);
        $this->testFallbackApiRepositoryMock =  $this->prophesize(\App\Repository\DrawFallbackApiRepository::class);
        $this->testDbRepositoryMock =  $this->prophesize(\App\Repository\DrawDbRepository::class);

        $this->useCase = new GetDrawUseCase(
            $this->testApiRepositoryMock->reveal(),
            $this->testFallbackApiRepositoryMock->reveal(),
            $this->testDbRepositoryMock->reveal());
    }

    public function testUseCaseReturnsValidResponseWhenApiWorks()
    {

        $this->testApiRepositoryMock
            ->findOneBy(['game' => 'euromillions'])
            ->shouldBeCalledTimes(1)
            ->willReturn($this->getDrawInstance());

        $this->testFallbackApiRepositoryMock
            ->findOneBy(['game' => 'euromillions'])
            ->shouldBeCalledTimes(0);


        $result = $this->useCase->execute();
        $this->assertInstanceOf(Draw::class, $result);
    }

    public function testUseCaseReturnsObjectWhenApiFails()
    {

        $this->testApiRepositoryMock
            ->findOneBy(['game' => 'euromillions'])
            ->shouldBeCalledTimes(1)
            ->willReturn($this->getDrawInstance())
            ->willThrow(new \Exception());;

        $this->testFallbackApiRepositoryMock
            ->findOneBy(['game' => 'euromillions'])
            ->shouldBeCalledTimes(1);


        $result = $this->useCase->execute();
        $this->assertInstanceOf(Draw::class, $result);
    }

    private function getDrawInstance()
    {
        return new Draw(1,
            1,
            "01/01/2018",
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9);
    }
}