<?php

namespace App\Tests\Infrastructure;

use App\Application\ForecastResponse;
use App\Application\GetForecastQuery;
use App\Infrastructure\GetForecastQueryHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class GetForecastQueryHandlerTest extends TestCase
{
    private SerializerInterface $serializer;
    private string $responseJson;

    protected function setUp(): void
    {
        $this->responseJson = (string) file_get_contents(__DIR__.'/../_data/forecastResponse.json');
        $this->serializer = new Serializer([
            new UnwrappingDenormalizer(),
            new ObjectNormalizer(),
            new ArrayDenormalizer(),
        ], [
            new JsonEncoder(),
        ]);
    }

    public function testHandleRequest(): void
    {
        $handler = new GetForecastQueryHandler(
            new MockHttpClient(
                new MockResponse($this->responseJson),
                'https://weather.local'
            ),
            $this->serializer
        );

        $response = $handler(new GetForecastQuery(2, 52.0552, 21.0042));
        $this->assertInstanceOf(ForecastResponse::class, $response);

        $forecasts = $response->getForecasts();
        $this->assertCount(2, $forecasts);
    }
}
