<?php

namespace App\Application;

class GetForecastQuery implements Query
{
    public function __construct(
        private int $days,
        private float $latitude,
        private float $longitude
    ) {
    }

    public function getDays(): int
    {
        return $this->days;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function __toString(): string
    {
        return $this->getLatitude().','.$this->getLongitude();
    }
}
