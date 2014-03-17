<?php

namespace Funk\Specification\Locator\Iterator;

use Behat\Testwork\Specification\SpecificationIterator;
use Behat\Testwork\Suite\Suite;

class Spec
{
    private $suite;
    private $file;
    private $basePath;

    public function __construct(\SplFileInfo $file, Suite $suite, $basePath)
    {
        $this->file = $file;
        $this->suite = $suite;
        $this->basePath = $basePath;
    }

    public function getExamples()
    {
        return new Example($this->suite, $this);
    }

    public function getPath()
    {
        return $this->file->getFilename();
    }

    public function getReflection()
    {
        $class = ltrim(str_replace(
            [$this->basePath, '/'],
            ['', '\\'],
            sprintf('%s/%s', $this->file->getPath(), $this->file->getBasename('.php'))
        ), '\\');

        return new \ReflectionClass($class);
    }
}
