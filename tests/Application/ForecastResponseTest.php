<?php

namespace App\Tests\Application;

use App\Application\ForecastResponse;
use App\Domain\Weather\Condition;
use App\Domain\Weather\Day;
use App\Domain\Weather\Forecast;
use PHPUnit\Framework\TestCase;

class ForecastResponseTest extends TestCase
{
    public function testObjectIsStringable(): void
    {
        $response = new ForecastResponse([
            new Forecast(new Day(new Condition('Its ok'))),
            new Forecast(new Day(new Condition('Rain'))),
        ]);

        $this->assertSame('Its ok - Rain', (string) $response);
    }
}
