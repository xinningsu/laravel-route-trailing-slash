<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Sulao\LRTS\Pagination\Paginator;

class PaginatorTest extends TestCache
{
    public function testLengthAwarePaginator()
    {
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
    }
}
