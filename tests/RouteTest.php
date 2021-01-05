<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Sulao\LRTS\Routing\Route;
use Sulao\LRTS\Routing\UriValidator;

class RouteTest extends TestCache
{
    public function testRoute()
    {
        $route = new Route(
            ['GET', 'HEAD'],
            'test/',
            ['App\Http\Controllers\TestController', 'index']
        );
        $validators = $route::getValidators();

        $this->assertInstanceOf(UriValidator::class, $validators[0]);
    }

    public function testPrefix()
    {
        $route = new Route(
            ['GET', 'HEAD'],
            '/',
            ['App\Http\Controllers\TestController', 'index']
        );
        $route->prefix('/test/');

        $this->assertEquals('test/', $route->uri);
    }
}
