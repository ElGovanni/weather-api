<?php

namespace App\Infrastructure;

use App\Application\ForecastResponse;
use App\Application\GetForecastQuery;
use App\Application\QueryHandler;
use App\Domain\Weather\Forecast;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetForecastQueryHandler implements QueryHandler
{
    public function __construct(
        private HttpClientInterface $weatherClient,
        private SerializerInterface $serializer,
    ) {
    }

    public function __invoke(GetForecastQuery $query): ForecastResponse
    {
        $request = $this->weatherClient->request(Request::METHOD_GET, '/v1/forecast.json', [
            'query' => [
                'q' => (string) $query,
                'days' => $query->getDays(),
            ],
        ]);

        /** @var Forecast[] $forecasts */
        $forecasts = $this->serializer->deserialize($request->getContent(), Forecast::class.'[]', 'json', [
            UnwrappingDenormalizer::UNWRAP_PATH => '[forecast][forecastday]',
        ]);

        return new ForecastResponse($forecasts);
    }
}
