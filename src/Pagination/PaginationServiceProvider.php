<?php

namespace Sulao\LRTS\Pagination;

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
        \Illuminate\Pagination\Paginator::currentPathResolver(function () {
            return Helper::appendTrailingSlashes(
                $this->app['request']->url(),
                $this->app['request']->getPathInfo()
            );
        });

        $this->app->alias(
            LengthAwarePaginator::class,
            \Illuminate\Pagination\LengthAwarePaginator::class
        );

        $this->app->alias(
            Paginator::class,
            \Illuminate\Pagination\Paginator::class
        );
    }
}
