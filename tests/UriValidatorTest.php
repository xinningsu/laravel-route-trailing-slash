<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Sulao\LRTS\Routing\UriValidator;
use Illuminate\Events\Dispatcher;
use Sulao\LRTS\Routing\Router;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UriValidatorTest extends TestCache
{
    public function testMatches()
    {
        $uriValidator = new UriValidator();
        $router = new Router(new Dispatcher(), new Container());
        $route = $router->addRoute(
            ['GET', 'HEAD'],
            'test/',
            ['App\Http\Controllers\TestController', 'index']
        );

        $request = new Request([], [], [], [], [], [
            'HTTP_HOST' => 'localhost',
            'REQUEST_URI' => '/test/?page=10',
            'REQUEST_METHOD' => 'GET',
            'QUERY_STRING' => 'page=10',
        ]);
        $route->matches($request);
        $this->assertEquals(1, $uriValidator->matches($route, $request));

        $request = new Request([], [], [], [], [], [
            'HTTP_HOST' => 'localhost',
            'REQUEST_URI' => '/test?page=10',
            'REQUEST_METHOD' => 'GET',
            'QUERY_STRING' => 'page=10',
        ]);

        $router::$mismatchAction = null;
        $this->assertEquals(1, $uriValidator->matches($route, $request));

        $router::$mismatchAction = 301;
        $exception = null;
        try {
            $uriValidator->matches($route, $request);
        } catch (HttpException $exception) {
        }
        $this->assertInstanceOf(HttpException::class, $exception);
        $this->assertEquals(301, $exception->getStatusCode());
        $header = $exception->getHeaders();
        $this->assertEquals(
            'http://localhost/test/?page=10',
            $header['Location']
        );

        $router::$mismatchAction = 302;
        $exception = null;
        try {
            $uriValidator->matches($route, $request);
        } catch (HttpException $exception) {
        }
        $this->assertInstanceOf(HttpException::class, $exception);
        $this->assertEquals(302, $exception->getStatusCode());
        $header = $exception->getHeaders();
        $this->assertEquals(
            'http://localhost/test/?page=10',
            $header['Location']
        );

        $router::$mismatchAction = 404;
        $this->expectException(NotFoundHttpException::class);
        $uriValidator->matches($route, $request);
    }
}
