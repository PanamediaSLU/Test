<?php

namespace App\UseCases;

use App\Entity\Draw;
use App\Exceptions\NotFoundException;
use App\Interfaces\IResultApi;

class GetDrawUseCase
{
    private $drawApiRepository;

    public function __construct(IResultApi $drawApiRepository)
    {
        $this->drawApiRepository = $drawApiRepository;
    }

    /**
     * @return Draw
     * @throws NotFoundException
     */
    public function execute(): Draw
    {
        try {
            $draw = $this->drawApiRepository->fetch();
        } catch (\Exception $exception) {
            throw new NotFoundException('Could not retreive draw data. ' . $exception->getMessage());
        }

        return $draw;
    }
}
