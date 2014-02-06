<?php

namespace Funk\Specification\Locator;

use Behat\Testwork\Suite\Suite;
use Behat\Testwork\Specification\Locator\SpecificationLocator;
use Funk\Specification\Locator\Iterator;

class Spec implements SpecificationLocator
{
    private $basePath;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    public function locateSpecifications(Suite $suite, $locator)
    {
        $iterator = new \RegexIterator(
            new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($this->findAbsolutePath($locator))
            ), '/^.+\.php$/i',
            \RegexIterator::MATCH
        );

        return new Iterator($suite, $iterator, $this->basePath);
    }

    private function findAbsolutePath($path)
    {
        if (is_file($path) || is_dir($path)) {
            return realpath($path);
        }

        if (null === $this->basePath) {
            return false;
        }

        if (is_file($this->basePath . DIRECTORY_SEPARATOR . $path)
            || is_dir($this->basePath . DIRECTORY_SEPARATOR . $path)
        ) {
            return realpath($this->basePath . DIRECTORY_SEPARATOR . $path);
        }

        return false;
    }
}
