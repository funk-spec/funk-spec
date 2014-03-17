<?php

namespace Funk\Environment;

use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Call\Callee;
use Behat\Testwork\Suite\Suite;
use ReflectionMethod;
use Funk;

class Spec implements Environment
{
    private $suite;
    private $spec;

    public function __construct(Suite $suite, Funk\Spec $spec = null)
    {
        $this->suite = $suite;
        $this->spec = $spec;
    }

    public function getSuite()
    {
        return $this->suite;
    }

    public function bindCallee(Callee $callee)
    {
        $callable = $callee->getCallable();

        if ($callee->isAnInstanceMethod()) {
            return [$this->spec, $callable->getName()];
        }

        return $callable;
    }
}
