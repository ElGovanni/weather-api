<?php

namespace App\Domain;

class City
{
    public function __construct(
        private string $name,
        private float $latitude,
        private float $longitude,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}
