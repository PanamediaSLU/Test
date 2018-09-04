<?php

namespace App\Repository;

use App\Entity\Draw;
use App\Interfaces\IResultApi;

class DrawFallbackApiRepository implements IResultApi
{
    public function __construct()
    {
    }

    /**
     * @return Draw
     */
    public function fetch(): Draw
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


