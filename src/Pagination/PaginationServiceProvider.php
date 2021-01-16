<?php

namespace Sulao\LRTS\Pagination;

use Illuminate\Pagination\LengthAwarePaginator as LaravelLengthAwarePaginator;
use Illuminate\Pagination\Paginator as LaravelPaginator;
use Sulao\LRTS\Helper;

class PaginationServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        LaravelPaginator::currentPathResolver(function () {
            return Helper::appendSlashes(
                $this->app['request']->url(),
                $this->app['request']->getPathInfo()
            );
        });

        $this->app->alias(
            LengthAwarePaginator::class,
            LaravelLengthAwarePaginator::class
        );

        $this->app->alias(
            Paginator::class,
            LaravelPaginator::class
        );
    }
}
