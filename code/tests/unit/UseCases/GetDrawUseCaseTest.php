<?php

namespace App\Tests\unit\UseCases;

use App\Entity\Draw;
use App\Exceptions\NotFoundException;
use App\Interfaces\IResultApi;
use App\UseCases\GetDrawUseCase;
use PHPUnit\Framework\TestCase;

class GetDrawUseCaseTest extends TestCase
{
    /** @var GetDrawUseCase */
    private $useCase;

    /** @var IResultApi */
    private $drawApiRepositoryMock;
    

    protected function setup()
    {
        $this->drawApiRepositoryMock =  $this->prophesize(\App\Repository\DrawApiRepository::class);

        $this->useCase = new GetDrawUseCase(
            $this->drawApiRepositoryMock->reveal());
    }

    public function testUseCaseReturnsValidResponseWhenApiWorks()
    {
        $this->drawApiRepositoryMock
            ->fetch()
            ->shouldBeCalledTimes(1)
            ->willReturn($this->getDrawInstance());

        $result = $this->useCase->execute();
        $this->assertInstanceOf(Draw::class, $result);
    }

    public function testUseCaseReturnsObjectWhenApiFails()
    {
        $this->expectException(NotFoundException::class);

        $this->drawApiRepositoryMock
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