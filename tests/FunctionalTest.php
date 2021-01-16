<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Config\Repository;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator as LaravelPaginator;
use Illuminate\Routing\RoutingServiceProvider as LaravelRoutingServiceProvider;
use Sulao\LRTS\Pagination\LengthAwarePaginator;
use Sulao\LRTS\Pagination\Paginator;
use Sulao\LRTS\Pagination\PaginationServiceProvider;
use Sulao\LRTS\Routing\Router;
use Sulao\LRTS\Routing\RoutingServiceProvider;
use Sulao\LRTS\Routing\UrlGenerator;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FunctionalTest extends TestCache
{
    public function testFunctional()
    {
        $app = new Application();
        $events = new Dispatcher();
        $request = new Request([], [], [], [], [], [
            'HTTP_HOST' => 'localhost',
            'REQUEST_URI' => '/test/?page=10',
            'REQUEST_METHOD' => 'GET',
            'QUERY_STRING' => 'page=10',
        ]);

        $app['events'] = $events;
        $app->instance('config', new Repository([]));
        $app->instance('request', $request);
        $app->register(LaravelRoutingServiceProvider::class);
        $app->register(RoutingServiceProvider::class);
        $app->register(PaginationServiceProvider::class);

        Router::$mismatchAction = 404;

        /**
         * @var Router $router
         */
        $router = $app->make('router');
        /**
         * @var UrlGenerator $url
         */
        $url = $app->make('url');

        $router->get('/test/', ['as' => 'test', function () {
            return 'test';
        }]);

        $this->assertEquals('http://localhost/test/', route('test'));
        $this->assertEquals('http://localhost/test/', $url->current());
        $this->assertEquals('http://localhost/test/2/', $url->to('/test/2/'));

        $paginator = new LengthAwarePaginator([], 281, 15, 1, [
            'path' => LaravelPaginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
        if (method_exists($paginator, 'path')) {
            $this->assertEquals('http://localhost/test/', $paginator->path());
        }
        $this->assertEquals(
            'http://localhost/test/?page=2',
            $paginator->nextPageUrl()
        );

        $paginator = new Paginator([1,2,3,4,5,6,7], 5, 1, [
            'path' => 'http://localhost/test/',
            'pageName' => 'page',
        ]);

        if (method_exists($paginator, 'path')) {
            $this->assertEquals('http://localhost/test/', $paginator->path());
        }
        $this->assertEquals(
            'http://localhost/test/?page=2',
            $paginator->nextPageUrl()
        );

        $response = $router->dispatch($request);
        $this->assertEquals(200, $response->getStatusCode());

        $exception = null;
        try {
            $router->dispatch(new Request([], [], [], [], [], [
                'HTTP_HOST' => 'localhost',
                'REQUEST_URI' => '/test',
                'REQUEST_METHOD' => 'GET',
                'QUERY_STRING' => 'page=10',
            ]));
        } catch (Exception $exception) {
        }
        $this->assertInstanceOf(NotFoundHttpException::class, $exception);

        $exception = null;
        try {
            $router->dispatch(new Request([], [], [], [], [], [
                'HTTP_HOST' => 'localhost',
                'REQUEST_URI' => '/test//',
                'REQUEST_METHOD' => 'GET',
                'QUERY_STRING' => 'page=10',
            ]));
        } catch (Exception $exception) {
        }
        $this->assertInstanceOf(NotFoundHttpException::class, $exception);

        Router::$mismatchAction = 301;
        $exception = null;
        try {
            $router->dispatch(new Request([], [], [], [], [], [
                'HTTP_HOST' => 'localhost',
                'REQUEST_URI' => '/test',
                'REQUEST_METHOD' => 'GET',
                'QUERY_STRING' => 'page=10',
            ]));
        } catch (HttpException $exception) {
        }
        $this->assertInstanceOf(HttpException::class, $exception);
        $this->assertEquals(301, $exception->getStatusCode());
        $header = $exception->getHeaders();
        $this->assertEquals(
            'http://localhost/test/?page=10',
            $header['Location']
        );

        Router::$mismatchAction = 302;
        $exception = null;
        try {
            $router->dispatch(new Request([], [], [], [], [], [
                'HTTP_HOST' => 'localhost',
                'REQUEST_URI' => '/test',
                'REQUEST_METHOD' => 'GET',
                'QUERY_STRING' => 'page=10',
            ]));
        } catch (HttpException $exception) {
        }
        $this->assertInstanceOf(HttpException::class, $exception);
        $this->assertEquals(302, $exception->getStatusCode());
        $header = $exception->getHeaders();
        $this->assertEquals(
            'http://localhost/test/?page=10',
            $header['Location']
        );
    }
}
