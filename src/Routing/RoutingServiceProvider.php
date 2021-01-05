<?php

namespace Sulao\LRTS\Routing;

class RoutingServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Router::class, function ($app) {
            return new Router($app['events'], $app);
        });
        $this->app->alias(Router::class, 'router');

        $this->app->singleton(UrlGenerator::class, function ($app) {
            $routes = $app['router']->getRoutes();
            $app->instance('routes', $routes);

            return new UrlGenerator(
                $routes,
                $app->rebinding('request', function ($app, $request) {
                    $app['url']->setRequest($request);
                }),
                $app['config']['app.asset_url']
            );
        });
        $this->app->alias(UrlGenerator::class, 'url');
    }
}
