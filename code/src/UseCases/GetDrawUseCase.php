<?php

namespace App\UseCases;

use App\Entity\Draw;
use App\Exceptions\CouldNotSaveDrawException;
use App\Exceptions\NotFoundException;
use App\Repository\DrawApiRepositoryInterface;
use App\Repository\DrawDbRepositoryInterface;

class GetDrawUseCase
{
    private $drawApiRepository;
    private $drawFallbackApiRepository;

    public function __construct(
        DrawApiRepositoryInterface $drawApiRepository,
        DrawApiRepositoryInterface $drawFallbackApiRepository,
        DrawDbRepositoryInterface $drawDbRepository
    ) {
        $this->drawApiRepository = $drawApiRepository;
        $this->drawFallbackApiRepository = $drawFallbackApiRepository;
        $this->drawDbRepository = $drawDbRepository;
    }

    /**
     * @return Draw
     * @throws NotFoundException
     */
    public function execute(): Draw
    {

        var_dump($this->drawDbRepository->getAll());die;
        try {
            $draw = $this->drawApiRepository->findOneBy(['game' => 'euromillions']);
        } catch (\Exception $exception) {
            try {
                $draw = $this->drawFallbackApiRepository->findOneBy(['game' => 'euromillions']);

            } catch (\Exception $exception) {
                throw new NotFoundException('Could not retreive draw data. ' . $exception->getMessage());
            }
        }

        $this->drawDbRepository->save($draw);

        return $draw;
    }
}
