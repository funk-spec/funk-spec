<?php

namespace Funk\Specification\Locator\Iterator;

use Behat\Testwork\Specification\SpecificationIterator;
use Behat\Testwork\Suite\Suite;
use Funk\Call\InvokableMethod;

class Example extends \ArrayIterator implements SpecificationIterator
{
    private $suite;

    public function __construct(Suite $suite, Spec $spec)
    {
        $this->suite = $suite;
        parent::__construct($this->getMethods($spec));
    }

    public function getSuite()
    {
        return $this->suite;
    }

    private function getMethods(Spec $spec)
    {
        $reflection = $spec->getReflection();
        $result = [];
        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC ^ \ReflectionMethod::IS_ABSTRACT);
        foreach ($methods as $method) {
            if (0 !== strpos($method->getName(), 'it_')) {
                continue;
            }
            $result[] = new InvokableMethod($method);
        }

        return $result;
    }
}
