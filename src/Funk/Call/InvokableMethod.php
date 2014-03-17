<?php

namespace Funk\Call;

use Behat\Testwork\Call\Callee;

class InvokableMethod implements Callee
{
    private $method;
    private $description;

    public function __construct(\ReflectionMethod $method, $description = null)
    {
        $this->method = $method;
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
        return $this->method;
    }

    public function getReflection()
    {
        return $this->method;
    }
}
