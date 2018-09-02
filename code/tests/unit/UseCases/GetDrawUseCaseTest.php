<?php

namespace App\Tests\unit\UseCases;

use App\Entity\Draw;
use App\Exceptions\NotFoundException;
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


    protected function setup()
    {
        $this->testApiRepositoryMock =  $this->prophesize(\App\Repository\DrawApiRepository::class);

        $this->useCase = new GetDrawUseCase(
            $this->testApiRepositoryMock->reveal());
    }

    public function testUseCaseReturnsValidResponseWhenApiWorks()
    {
        $this->testApiRepositoryMock
            ->fetch()
            ->shouldBeCalledTimes(1)
            ->willReturn($this->getDrawInstance());

        $result = $this->useCase->execute();
        $this->assertInstanceOf(Draw::class, $result);
    }

    public function testUseCaseReturnsObjectWhenApiFails()
    {
        $this->expectException(NotFoundException::class);

        $this->testApiRepositoryMock
            ->fetch()
            ->shouldBeCalledTimes(1)
            ->willReturn($this->getDrawInstance())
            ->willThrow(new \Exception());;

        $this->useCase->execute();
    }

    private function getDrawInstance()
    {
        return new Draw(1,
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