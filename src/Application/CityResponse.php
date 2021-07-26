<?php

namespace App\Application;

use App\Domain\City;

class CityResponse
{
    /**
     * @param City[] $cities
     */
    public function __construct(
        private array $cities
    ) {
    }

    /**
     * @return City[]
     */
    public function getCities(): array
    {
        return $this->cities;
    }
}
