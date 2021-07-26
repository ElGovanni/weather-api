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

## Configuration
For proper operation of the application, you need to add an environment variable with your [WeatherApi key](https://www.weatherapi.com) using command below but with your key instead of `<YOUR_API_KEY>`.
```bash
echo "WEATHER_API_KEY=<YOUR_API_KEY>" > .env.local
```
Or if you want to avoid bash just create new file .env.local with `WEATHER_API_KEY=<YOUR_API_KEY>` in root project directory.

## Tests
You should enter into docker php container using command below before you are going to execute rest of test commands below.

```bash
docker-compose exec php bash
```

### Unit
Master branch tests coverage report is available on [project github page](https://elgovanni.github.io/weather-api)

```bash
composer tests
```
Execute this to run tests and generate coverage report.
```bash
composer tests:coverage
```

### Coding standard
Below command check coding standards in src and tests directory.

```bash
composer ecs
```

### Static code analysis
Static analysis using PHPStan tool to find errors before run app.

```bash
composer stan
```


