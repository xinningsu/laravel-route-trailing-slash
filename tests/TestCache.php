<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

abstract class TestCache extends \PHPUnit\Framework\TestCase
{
    /**
     * Return a closure to test protected method
     *
     * @param object $instance
     * @param string $method
     *
     * @return Closure
     */
    protected function protectMethod($instance, $method)
    {
        $class = new ReflectionClass(get_class($instance));
        $method = $class->getMethod($method);
        $method->setAccessible(true);

        return function () use ($instance, $method) {
            return $method->invokeArgs($instance, func_get_args());
        };
    }
}
