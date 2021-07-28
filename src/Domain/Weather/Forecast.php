<?php

namespace App\Domain\Weather;

class Forecast
{
    public function __construct(
        private Day $day
    ) {
    }

    public function getDay(): Day
    {
        return $this->day;
    }
}
