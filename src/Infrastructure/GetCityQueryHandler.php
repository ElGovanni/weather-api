<?php

namespace App\Infrastructure;

use App\Application\CityResponse;
use App\Application\GetCityQuery;
use App\Application\QueryHandler;
use App\Domain\City;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetCityQueryHandler implements QueryHandler
{
    public function __construct(
        private HttpClientInterface $musementClient,
        private SerializerInterface $serializer,
    ) {
    }

    public function __invoke(GetCityQuery $query): CityResponse
    {
        $request = $this->musementClient->request(Request::METHOD_GET, '/api/v3/cities');

        /** @var City[] $response */
        $response = $this->serializer->deserialize($request->getContent(), City::class.'[]', 'json');

        return new CityResponse($response);
    }
}
