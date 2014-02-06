<?php

namespace Funk\Call;

use Behat\Testwork\Call\Callee;
use Funk\Specification\Locator\Iterator\Spec;

class InvokableMethod implements Callee
{
    private $method;
    private $spec;
    private $description;

    public function __construct(\ReflectionMethod $method, Spec $spec, $description = null)
    {
        $this->method = $method;
        $this->spec = $spec;
        $this->description = $description;
    }

    public function getPath()
    {
        return $this->method->getDeclaringClass()->getFilename();
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function isAMethod()
    {
        return true;
    }

    public function isAnInstanceMethod()
    {
        return true;
    }

    public function getCallable()
    {
        return [
            $this->method->getDeclaringClass()->newInstance(),
            $this->method->getName(),
        ];
    }

    public function getReflection()
    {
        return $this->method;
    }
}
