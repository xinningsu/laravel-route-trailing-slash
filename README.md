# Laravel route trailing slash

Let laravel route work as exactly as how we define it including the trailing slash.

[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](./LICENSE)
[![Build Status](https://api.travis-ci.org/xinningsu/laravel-route-trailing-slash.svg?branch=master)](https://travis-ci.org/xinningsu/laravel-route-trailing-slash)
[![Coverage Status](https://coveralls.io/repos/github/xinningsu/laravel-route-trailing-slash/badge.svg?branch=master)](https://coveralls.io/github/xinningsu/laravel-route-trailing-slash)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/xinningsu/laravel-route-trailing-slash/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/xinningsu/laravel-route-trailing-slash)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/xinningsu/laravel-route-trailing-slash/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/g/xinningsu/laravel-route-trailing-slash)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=xinningsu_laravel-route-trailing-slash&metric=alert_status)](https://sonarcloud.io/dashboard?id=xinningsu_laravel-route-trailing-slash)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=xinningsu_laravel-route-trailing-slash&metric=reliability_rating)](https://sonarcloud.io/dashboard?id=xinningsu_laravel-route-trailing-slash)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=xinningsu_laravel-route-trailing-slash&metric=security_rating)](https://sonarcloud.io/dashboard?id=xinningsu_laravel-route-trailing-slash)
[![Maintainability](https://api.codeclimate.com/v1/badges/18669386ce65532b228f/maintainability)](https://codeclimate.com/github/xinningsu/laravel-route-trailing-slash/maintainability)

# Background

Currently when we define a route, Laravel will trim all the trailing slashes, output the route url without any trailing slash. When we access an url with trailing slashes, Laravel also will trim them. That makes the trailing slashes meaningless, sometimes it's quite annoying.

## Define a route like this

```php
use App\Http\Controllers\PartnersController;

Route::get('/partners/', [PartnersController::class, 'index'])->name('partners');
```

## Output the route url

```php
echo route('partners');

```

### Current behavior

```
https://laravel.com/partners
```

### Expected behavior

```
https://laravel.com/partners/
```


## Pagination render

Using database query builder or LengthAwarePaginator/Paginator

### Current behavior

```
https://laravel.com/partners?page=2
```

### Expected behavior

```
https://laravel.com/partners/?page=2
```

# Installation

```
composer require xinningsu/laravel-route-trailing-slash
```

There are two service providers, as the router service provider has to register at the very beginning before laravel http kernel class instantiation, so I can not make it work by Laravel Package Auto-Discovery function. Have to manually add it.

### RoutingServiceProvider

open `bootstrap/app.php`, right after app instantiation

```php
$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

```

add
```php
$app->register(Sulao\LRTS\Routing\RoutingServiceProvider::class);

```

### PaginationServiceProvider

Pagination Service Provider has to be added **after** laravel original Pagination Service Provider.

add `Sulao\LRTS\Pagination\PaginationServiceProvider::class` to config/app.php under `providers` element, **after** `Illuminate\Pagination\PaginationServiceProvider::class`

```php
[
    Illuminate\Pagination\PaginationServiceProvider::class,
    
    // ...
    
    /*
    * Package Service Providers...
    */
    Sulao\LRTS\Pagination\PaginationServiceProvider::class,

   // ...
];
        
```

That's it, now we can generate url with/without trailing slash, same as the definition of route.

# Mismatch action

Currently Laravel will trim trailing slashes of access url, so no matter how many trailing slashes the url has, it makes no difference.

### Current behavior

| URL       | Status  |
| ------------- |-------------  |
| [https://laravel.com/partners](https://laravel.com/partners) | 200 |
| [https://laravel.com/partners/](https://laravel.com/partners/) | 200 |
| [https://laravel.com/partners////](https://laravel.com/partners////) | 200 |


Now we can custom the mismatch action, such as abort 404, or 301/302 redirect, if route mismatch only because of trailing slash.


### 404 action

open `app/Providers/AppServiceProvider.php`, add below line to `register` method

```php

\Sulao\LRTS\Routing\Router::$mismatchAction = 404;
```

Now the behavior became

| URL       | Status  |
| ------------- |-------------  |
| [https://laravel.com/partners](https://laravel.com/partners) | 404 |
| [https://laravel.com/partners/](https://laravel.com/partners/) | 200 |
| [https://laravel.com/partners////](https://laravel.com/partners////) | 404 |


### 301/302 action

open `app/Providers/AppServiceProvider.php`, add below line to `register` method

```php

\Sulao\LRTS\Routing\Router::$mismatchAction = 301;
```

Now the behavior became

| URL       | Status  |
| ------------- |-------------  |
| [https://laravel.com/partners](https://laravel.com/partners) | 301 redirect to [https://laravel.com/partners/](https://laravel.com/partners/) |
| [https://laravel.com/partners/](https://laravel.com/partners/) | 200 |
| [https://laravel.com/partners////](https://laravel.com/partners////) | 301 redirect to [https://laravel.com/partners/](https://laravel.com/partners/) |



# License

[MIT](./LICENSE)
