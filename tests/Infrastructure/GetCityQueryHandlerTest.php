<?php

namespace App\Tests\Infrastructure;

use App\Application\CityResponse;
use App\Application\GetCityQuery;
use App\Infrastructure\GetCityQueryHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class GetCityQueryHandlerTest extends TestCase
{
    private SerializerInterface $serializer;
    private string $responseJson;

    protected function setUp(): void
    {
        $this->responseJson = (string) file_get_contents(__DIR__.'/../_data/cityResponse.json');
        $this->serializer = new Serializer([new UnwrappingDenormalizer(), new ObjectNormalizer(), new ArrayDenormalizer()], [new JsonEncoder()]);
    }

    public function testHandleRequest(): void
    {
        $handler = new GetCityQueryHandler(
            new MockHttpClient(
                new MockResponse($this->responseJson),
                'https://musement.local'
            ),
            $this->serializer
        );

        $response = $handler(new GetCityQuery());
        $this->assertInstanceOf(CityResponse::class, $response);

        $cities = $response->getCities();
        $this->assertCount(3, $cities);
    }
}
