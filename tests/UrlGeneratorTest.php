<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Sulao\LRTS\Routing\UrlGenerator;
use Sulao\LRTS\Routing\RouteUrlGenerator;

class UrlGeneratorTest extends TestCache
{
    public function testFormat()
    {
        $urlGenerator = new UrlGenerator(new RouteCollection(), new Request());
        $this->assertEquals(
            'http://localhost/test/',
            $urlGenerator->format('http://localhost', '/test/')
        );
    }

    public function testRouteUrl()
    {
        $urlGenerator = new UrlGenerator(new RouteCollection(), new Request());
        $method = $this->protectMethod($urlGenerator, 'routeUrl');
        $this->assertInstanceOf(
            RouteUrlGenerator::class,
            $method()
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
