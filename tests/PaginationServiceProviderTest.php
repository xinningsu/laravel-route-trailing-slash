<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as LaravelLengthAwarePaginator;
use Illuminate\Pagination\Paginator as laravelPaginator;
use Sulao\LRTS\Pagination\LengthAwarePaginator;
use Sulao\LRTS\Pagination\Paginator;
use Sulao\LRTS\Pagination\PaginationServiceProvider;

class PaginationServiceProviderTest extends TestCache
{
    public function testRegister()
    {
        $request = new Request([], [], [], [], [], [
            'HTTP_HOST' => 'localhost',
            'REQUEST_URI' => '/test/?page=10',
            'REQUEST_METHOD' => 'GET',
            'QUERY_STRING' => 'page=10',
        ]);

        $app = new Application();
        $app->instance('request', $request);

        $provider = new PaginationServiceProvider($app);
        $provider->register();

        $this->assertEquals(
            'http://localhost/test/',
            laravelPaginator::resolveCurrentPath()
        );

        $this->assertEquals(
            LengthAwarePaginator::class,
            $app->getAlias(LaravelLengthAwarePaginator::class)
        );

        $this->assertEquals(
            Paginator::class,
            $app->getAlias(laravelPaginator::class)
        );
    }
}
