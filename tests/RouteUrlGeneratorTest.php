<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Sulao\LRTS\Routing\UrlGenerator;
use Sulao\LRTS\Routing\RouteUrlGenerator;

class RouteUrlGeneratorTest extends TestCache
{
    public function testReplaceRouteParameters()
    {
        $request = new Request();
        $urlGenerator = new UrlGenerator(new RouteCollection(), $request);
        $routeUrlGenerator = new RouteUrlGenerator($urlGenerator, $request);

        $class = new ReflectionClass(get_class($routeUrlGenerator));
        $method = $class->getMethod('replaceRouteParameters');
        $method->setAccessible(true);
        $parameters = [];
        $path = $method->invokeArgs(
            $routeUrlGenerator,
            ['/test/', &$parameters]
        );

        $this->assertEquals('test/', $path);
    }
}
