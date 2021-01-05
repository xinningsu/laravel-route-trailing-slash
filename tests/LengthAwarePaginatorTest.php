<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Sulao\LRTS\Pagination\LengthAwarePaginator;

class LengthAwarePaginatorTest extends TestCache
{
    public function testLengthAwarePaginator()
    {
        $paginator = new LengthAwarePaginator([], 281, 15, 1, [
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
    }
}
