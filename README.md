# Weather api
This application integrates Musement's API with [WeatherApi](https://www.weatherapi.com)

* Author: [Stefan Touhami](https://touhami.pl)

![example workflow](https://github.com/elgovanni/weather-api/actions/workflows/ci.yml/badge.svg)

## Requirements
* [Git](https://git-scm.com/downloads)
* [Docker](https://docs.docker.com/install) and [Docker Compose](https://docs.docker.com/compose/install)
* WeatherApi Key

## Installation
To install application you have to execute few commands 
```bash
git clone git@github.com:ElGovanni/weather-api.git
cd weather-api
docker-compose up
```

Now we have to jump into php container using
```bash
docker-compose exec php bash
```

Via php bash we will install dependencies
```bash
composer install
```

