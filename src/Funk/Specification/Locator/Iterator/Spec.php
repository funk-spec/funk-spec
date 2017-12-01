<?php

namespace Funk\Specification\Locator\Iterator;

use Behat\Testwork\Specification\SpecificationIterator;
use Behat\Testwork\Suite\Suite;

use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Reflector\ClassReflector;
use Roave\BetterReflection\SourceLocator\Type\SingleFileSourceLocator;

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
        $astLocator = (new BetterReflection())->astLocator();
        $reflector = new ClassReflector(new SingleFileSourceLocator($this->file->getPathname(), $astLocator));
        $classes = $reflector->getAllClasses();


        if (!empty(array_filter($classes))) {
            return new \ReflectionClass(current($classes)->getName());
        }
    }
}
