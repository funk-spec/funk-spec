<?php

namespace Funk\Suite\Setup;

use Behat\Testwork\Suite\Suite;
use Behat\Testwork\Suite\Setup\SuiteSetup;
use Symfony\Component\ClassLoader\ClassLoader;

class Autoload implements SuiteSetup
{
    private $autoloader;

    public function __construct(ClassLoader $autoloader)
    {
        $this->autoloader = $autoloader;
    }

    public function supportsSuite(Suite $suite)
    {
        return true;
    }

    public function setupSuite(Suite $suite)
    {
    }
}
