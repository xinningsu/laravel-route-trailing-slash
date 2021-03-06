<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Config\Repository;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Sulao\LRTS\Routing\Router;
use Sulao\LRTS\Routing\RoutingServiceProvider;
use Sulao\LRTS\Routing\UrlGenerator;
use Sulao\LRTS\Routing\UriValidator;

class RoutingServiceProviderTest extends TestCache
{
    public function testRegister()
    {
        $app = new Application();
        $app['events'] = new Dispatcher();
        $app->instance('config', new Repository([]));
        $app->instance('request', new Request([], [], [], [], [], [
            'HTTP_HOST' => 'localhost',
            'REQUEST_URI' => '/test/?page=10',
            'REQUEST_METHOD' => 'GET',
            'QUERY_STRING' => 'page=10',
        ]));

        $provider = new RoutingServiceProvider($app);
        $provider->register();

        $this->assertInstanceOf(Router::class, $app->make(Router::class));
        $this->assertEquals(Router::class, $app->getAlias('router'));
        $this->assertInstanceOf(Router::class, $app['router']);

        $this->assertInstanceOf(
            UrlGenerator::class,
            $app->make(UrlGenerator::class)
        );
        $this->assertEquals(UrlGenerator::class, $app->getAlias('url'));
        $this->assertInstanceOf(UrlGenerator::class, $app['url']);

        // trigger app rebind request closure in RoutingServiceProvider
        // where creating new UrlGenerator instance
        $app->instance('request', new Request([], [], [], [], [], [
            'HTTP_HOST' => 'localhost',
            'REQUEST_URI' => '/test/2/',
            'REQUEST_METHOD' => 'GET',
            'QUERY_STRING' => 'page=10',
        ]));
        $this->assertInstanceOf(
            UrlGenerator::class,
            $app->make(UrlGenerator::class)
        );

        $validators = Route::getValidators();
        $replaced = false;
        foreach ($validators as $validator) {
            if ($validator instanceof UriValidator) {
                $replaced = true;
            }
        }
        $this->assertTrue($replaced);
    }
}
