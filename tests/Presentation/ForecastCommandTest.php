<?php

namespace App\Tests\Presentation;

use App\Application\CityResponse;
use App\Application\ForecastResponse;
use App\Application\GetCityQuery;
use App\Application\QueryBus;
use App\Domain\City;
use App\Domain\Weather\Condition;
use App\Domain\Weather\Day;
use App\Domain\Weather\Forecast;
use App\Presentation\Cli\ForecastCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class ForecastCommandTest extends KernelTestCase
{
    private const CITY = 'Warsaw';
    private const CONDITION = 'great';
    private Application $application;
    private QueryBus $queryBus;

    public function setUp(): void
    {
        $this->application = new Application(static::createKernel());

        $this->queryBus = $this->createMock(QueryBus::class);
        $forecastResponse = function () {
            $arg = func_get_arg(0);
            if ($arg instanceof GetCityQuery) {
                return new CityResponse([
                    new City(self::CITY, 52.01, 21.01),
                ]);
            }

            return new ForecastResponse([
                new Forecast(
                    new Day(new Condition(self::CONDITION))
                ),
            ]);
        };

        $this->queryBus->method('handle')
            ->will($this->returnCallback($forecastResponse));
    }

    public function testExecute(): void
    {
        /** @var Command $command */
        $command = $this->application->add(new ForecastCommand($this->queryBus));
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'days' => 1,
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString(sprintf('Processed city %s | %s', self::CITY, self::CONDITION), $output);
        $status = $commandTester->getStatusCode();
        $this->assertSame(Command::SUCCESS, $status);
    }

    public function testExecuteFailArgument(): void
    {
        /** @var Command $command */
        $command = $this->application->add(new ForecastCommand($this->queryBus));
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'days' => 'NaN',
        ]);

        $status = $commandTester->getStatusCode();
        $this->assertSame(Command::FAILURE, $status);
    }
}
