<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Sulao\LRTS\Helper;

class HelperTest extends TestCache
{
    public function testAppendSlashes()
    {
        $this->assertEquals(
            '/',
            Helper::appendSlashes('/', '/')
        );

        $this->assertEquals(
            '/test',
            Helper::appendSlashes('/test', '/ttt')
        );

        $this->assertEquals(
            'http://localhost/test/',
            Helper::appendSlashes('http://localhost/test', '/test/')
        );

        $this->assertEquals(
            '/test//',
            Helper::appendSlashes('/test', '/test//')
        );

        $this->assertEquals(
            '/test',
            Helper::appendSlashes('/test/', '/test')
        );

        $this->assertEquals(
            '/test',
            Helper::appendSlashes('/test//', '/test')
        );
    }

    public function testGetTrailingSlashes()
    {
        $this->assertEquals(
            '/',
            Helper::getTrailingSlashes('/')
        );

        $this->assertEquals(
            '',
            Helper::getTrailingSlashes('')
        );

        $this->assertEquals(
            '//',
            Helper::getTrailingSlashes('//')
        );

        $this->assertEquals(
            '',
            Helper::getTrailingSlashes('/test')
        );
    }
}
