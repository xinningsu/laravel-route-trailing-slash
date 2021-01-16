<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Sulao\LRTS\Routing\Router;

class RouterTest extends TestCache
{
    public function testAddRoute()
    {
        $router = new Router(new Dispatcher(), new Container());
        $route = $router->addRoute(['GET'], '/test/', function () {
            return 'test';
        });

        $this->assertEquals('/test/', $route->originalUri);
    }
}
