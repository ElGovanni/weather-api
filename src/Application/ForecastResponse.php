<?php

namespace App\Application;

use App\Domain\Weather\Forecast;
use Stringable;

class ForecastResponse implements Stringable
{
    /**
     * @param Forecast[] $forecasts
     */
    public function __construct(
        private array $forecasts
    ) {
    }

    /**
     * @return Forecast[]
     */
    public function getForecasts(): array
    {
        return $this->forecasts;
    }

    public function __toString(): string
    {
        $array = [];
        foreach ($this->getForecasts() as $forecast) {
            $array[] = $forecast->getDay()->getCondition()->getText();
        }

        return implode(' - ', $array);
    }
}
