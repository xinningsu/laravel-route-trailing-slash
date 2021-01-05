<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Http\Request;
use Sulao\LRTS\Routing\Route;
use Sulao\LRTS\Routing\UriValidator;

class UriValidatorTest extends TestCache
{
    public function testMatches()
    {
        $uriValidator = new UriValidator();

        $route = $this->getMockBuilder(Route::class)
            ->setConstructorArgs([
                ['GET', 'HEAD'],
                'test/',
                ['App\Http\Controllers\TestController', 'index']
            ])
            ->getMock();
        $route->method('getCompiled')->willReturn(new Mock());

        $request = new Request([], [], [], [], [], [
            'HTTP_HOST' => 'localhost',
            'REQUEST_URI' => '/test/?page=10',
            'REQUEST_METHOD' => 'GET',
            'QUERY_STRING' => 'page=10',
        ]);
        $this->assertNotEmpty($uriValidator->matches($route, $request));

        $request = new Request([], [], [], [], [], [
            'REQUEST_URI' => '/test?page=10',
            'REQUEST_METHOD' => 'GET',
            'QUERY_STRING' => 'page=10',
        ]);
        $this->assertEmpty($uriValidator->matches($route, $request));
    }
}
