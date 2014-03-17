<?php

namespace Funk\Specification\Locator;

use Behat\Testwork\Specification\SpecificationIterator;
use Behat\Testwork\Suite\Suite;

class Iterator extends \FilterIterator implements SpecificationIterator
{
    private $suite;
    private $basePath;

    public function __construct(Suite $suite, \Iterator $files, $basePath)
    {
        parent::__construct($files);
        $this->suite = $suite;
        $this->basePath = $basePath;
    }

    public function accept()
    {
        try {
            return $this->current()->getReflection()->implementsInterface('Funk\Spec');
        }
        catch (\ReflectionException $e) {
            return false;
        }
    }

    public function current()
    {
        return new Iterator\Spec(
            parent::current(),
            $this->suite,
            $this->basePath
        );
    }

    public function getSuite()
    {
        return $this->suite;
    }
}
