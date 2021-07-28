<?php

namespace App\Presentation\Cli;

use App\Application\CityResponse;
use App\Application\GetCityQuery;
use App\Application\GetForecastQuery;
use App\Application\QueryBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ForecastCommand extends Command
{
    private const DAYS_ARGUMENT = 'days';

    protected static $defaultName = 'app:forecast';
    protected static $defaultDescription = 'Display list of cities with forecast';

    public function __construct(
        private QueryBus $queryBus,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                self::DAYS_ARGUMENT,
                InputArgument::OPTIONAL,
                'Numbers of days to forecast',
                '2'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $days = $input->getArgument(self::DAYS_ARGUMENT);
        if (! is_numeric($days)) {
            $output->writeln('Only numeric values');

            return Command::FAILURE;
        }

        if ($days > 3) {
            $output->writeln('Maximum 3 days');

            return Command::FAILURE;
        }

        /** @var CityResponse $cities */
        $cities = $this->queryBus->handle(new GetCityQuery());

        foreach ($cities->getCities() as $city) {
            $forecasts = $this->queryBus->handle(
                new GetForecastQuery((int) $days, $city->getLatitude(), $city->getLongitude())
            );

            $output->writeln(
                sprintf('Processed city %s | %s', $city->getName(), $forecasts)
            );
        }

        return Command::SUCCESS;
    }
}
