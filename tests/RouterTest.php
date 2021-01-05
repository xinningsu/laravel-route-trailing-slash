<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Container\Container;
use Illuminate\Support\Testing\Fakes\EventFake;
use Sulao\LRTS\Routing\Route;
use Sulao\LRTS\Routing\Router;

class RouterTest extends TestCache
{
    public function testPrefix()
    {
        $method = $this->protectMethod($this->getRouter(), 'prefix');
        $this->assertEquals(
            'test/',
            $method('/test/')
        );
    }

    public function testNewRoute()
    {
        $this->assertInstanceOf(Route::class, $this->getRouter()->newRoute(
            ['GET', 'HEAD'],
            'test/',
            ['App\Http\Controllers\TestController', 'index']
        ));
    }

    protected function getRouter()
    {
        $events = $this->createMock(EventFake::class);
        $container = $this->createMock(Container::class);

        return new Router($events, $container);
    }
}
