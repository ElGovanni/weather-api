# Weather api
This application integrates Musement's API with [WeatherApi](https://www.weatherapi.com)

* Author: [Stefan Touhami](https://touhami.pl)
* Consulting company: [Boldare](https://boldare.com)

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

## Usage
To display forecast for cities from Musement's API execute below command inside php container
```bash
symfony console app:forecast 
```
You can change default 2 days of forecast to other in range 1:3 by using argument days, for example:
```bash
symfony console app:forecast 3
```

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

# Musement - Backend tech homework
## Step 1 | Development
First step is about application that gets the list of the cities from Musement's api and foreach forecast by WeatherApi.
To run application you have to follow [installation](#installation), [configuration](#configuration) and [usage](#usage) guides.

## Step 2 | Api design
My recommendation is to create a new `/api/v3/forecasts` endpoint for GET and POST methods because for example it gives us option to fetch forecast for array of cityId which could not be available if we just extend `/api/v3/cities/{id}/forecasts`.
* endpoint/s to set the forecast for a specific city

Endpoint:
```http request
POST /api/v3/forecasts
```
Request json body:
```json
{
  "cityId": integer,
  "date": string,
  "condition": string
}
```
Response json body:
```json
{
  "id": integer,
  "cityId": integer,
  "date": string,
  "condition": string
}
```
Sample request body:
```json
{
  "cityId": 1,
  "date": "2021-07-29",
  "condition": "Partly cloudy"
}
```
201 - Created:
```json
{
  "cityId": 1,
  "date": "2021-07-29",
  "condition": "Partly cloudy"
}
```
400 - Not valid request:
```json
{
  "violations": [
    {
      "propertyPath": "date",
      "message": "This value is not a Date."
    }
  ] 
}
```
Request payload:

| parameter | description                | required | format  |
|-----------|----------------------------|----------|---------|
| cityId    | id of a city               | true     | integer |
| date      | date of weather forecast   | true     | string  |
| condition | weather forecast condition | true     | string  |

* endpoint/s to read the forecast for a specific city

Endpoint:
`GET /api/v3/forecasts`

Url structure:
`GET /api/v3/forecasts?cityId[]=1&cityId[]=2&dateFrom=2021-07-25&dateTo=2021-07-26`

Response json structure:
```json
[
  {
    "id": integer,
    "cityId": integer,
    "date": string,
    "condition": string
  }
]
```
200 - Response
```json
[
  {
    "id": 1,
    "cityId": 1,
    "date": "2021-07-25",
    "condition": "Sunny"
  },
  {
    "id": 2,
    "cityId": 1,
    "date": "2021-07-26",
    "condition": "Partly cloudy"
  }
]
```
400 - Not valid request:
```json
{
  "violations": [
    {
      "propertyPath": "dateFrom",
      "message": "This value is not a Date."
    }
  ] 
}
```
Request query parameters:

| parameter | description               | required | format    |
|-----------|---------------------------|----------|-----------|
| cityId    | array of cities id        | false    | array[id] |
| dateFrom  | start date o the forecast | false    | string    |
| dateTo    | end date of the forecast  | false    | string    |
