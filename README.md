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
```

Install composer dependencies
```bash
docker-compose run --rm composer install
```

## Configuration
For proper operation of the application, you need to add an environment variable with your [WeatherApi key](https://www.weatherapi.com) using command below but with your key instead of `<YOUR_API_KEY>`.
```bash
echo "WEATHER_API_KEY=<YOUR_API_KEY>" > .env.local
```
Or if you want to avoid bash just create new file .env.local with `WEATHER_API_KEY=<YOUR_API_KEY>` in root project directory.

## Usage
To display forecast for cities from Musement's API execute below command inside php container
```bash
docker-compose run --rm php bin/console app:forecast
```
You can change default 2 days of forecast to other in range 1:3 by using argument days, for example:
```bash
docker-compose run --rm php bin/console app:forecast 3
```

## Tests
You should enter into docker php container using command below before you are going to execute rest of test commands below.

### Unit
Master branch tests coverage report is available on [project github page](https://elgovanni.github.io/weather-api)

```bash
docker-compose run --rm php bin/phpunit
```
Execute this to run tests and generate coverage report.
```bash
docker-compose run --rm php bin/phpunit --coverage-html var/coverage-report
```

### Coding standard
Below command check coding standards in src and tests directory.

```bash
docker-compose run --rm php ./vendor/bin/ecs check
```

### Static code analysis
Static analysis using PHPStan tool to find errors before run app.

```bash
docker-compose run --rm php ./vendor/bin/phpstan analyse
```


