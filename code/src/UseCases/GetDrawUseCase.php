<?php

namespace App\UseCases;

use App\Entity\Draw;
use App\Repository\DrawApiRepositoryInterface;
use App\Repository\DrawDbRepositoryInterface;

class GetDrawUseCase
{
    private $testApiRepository;
    private $testFallbackApiRepository;

    public function __construct(
        DrawApiRepositoryInterface $testApiRepository,
        DrawApiRepositoryInterface $testFallbackApiRepository,
        DrawDbRepositoryInterface $testDbRepository
    ) {
        $this->testApiRepository = $testApiRepository;
        $this->testFallbackApiRepository = $testFallbackApiRepository;
        $this->testDbRepository = $testDbRepository;
    }

    /**
     * @param array $renditionData
     * @return Draw
     * @throws DatabaseException
     * @throws InvalidInputException
     */
    public function execute(): Draw
    {

        try {
            $test = $this->testApiRepository->findOneBy(['game' => 'euromillions']);
        } catch (\Exception $exception) {
            try {
                $test = $this->testFallbackApiRepository->findOneBy(['game' => 'euromillions']);
            } catch (\Exception $exception) {
                throw new \RuntimeException('Could not retreive data. '.$exception->getMessage());
            }
        }

       // $this->testDbRepository->save($test);

        return $test;
    }
}
