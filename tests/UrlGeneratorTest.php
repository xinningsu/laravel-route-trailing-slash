<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Sulao\LRTS\Routing\Router;
use Sulao\LRTS\Routing\UrlGenerator;

class UrlGeneratorTest extends TestCache
{
    public function testToRoute()
    {
        $router = new Router(new Dispatcher(), new Container());
        $route = $router->get('/test/', [
            'as' => 'test',
            'uses' => 'TestController@index',
        ]);

        $urlGenerator = new UrlGenerator(
            new RouteCollection(),
            new Request([], [], [], [], [], [
                'HTTP_HOST' => 'localhost',
                'REQUEST_URI' => '/test/',
                'REQUEST_METHOD' => 'GET',
                'QUERY_STRING' => 'page=10',
            ])
        );
        $this->assertEquals(
            'http://localhost/test/',
            $urlGenerator->toRoute($route, [], true)
        );
    }

    public function testTo()
    {
        $urlGenerator = new UrlGenerator(
            new RouteCollection(),
            new Request([], [], [], [], [], [
                'HTTP_HOST' => 'localhost',
                'REQUEST_URI' => '/test/2/',
                'REQUEST_METHOD' => 'GET',
                'QUERY_STRING' => 'page=10',
            ])
        );

        $this->assertEquals(
            'http://localhost/test/2/',
            $urlGenerator->current()
        );

        $this->assertEquals(
            'http://localhost/test/3/',
            $urlGenerator->to('/test/3/')
        );
    }
}
