<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Sulao\LRTS\Helper;

class HelperTest extends TestCache
{
    public function testAppendTrailingSlashes()
    {
        $this->assertEquals(
            '/',
            Helper::appendTrailingSlashes('/', '/')
        );

        $this->assertEquals(
            '/test',
            Helper::appendTrailingSlashes('/test', '/ttt')
        );

        $this->assertEquals(
            'http://localhost/test/',
            Helper::appendTrailingSlashes('http://localhost/test', '/test/')
        );

        $this->assertEquals(
            '/test//',
            Helper::appendTrailingSlashes('/test', '/test//')
        );
    }
}
