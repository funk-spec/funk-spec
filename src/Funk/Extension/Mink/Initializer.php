<?php

namespace Funk\Extension\Mink;

use Funk\Initializer\Spec as SpecInitializer;
use Funk\Spec;
use Behat\Testwork\Suite\Suite;
use Behat\Mink\Mink;

class Initializer implements SpecInitializer
{
    private $mink;

    public function __construct(Mink $mink)
    {
        $this->mink = $mink;
    }

    public function isSupported(Suite $suite, \ReflectionClass $reflect)
    {
        return true;
    }

    public function resolveArguments(Suite $suite, \ReflectionMethod $constructor)
    {
        $arguments = $constructor->getParameters();
        foreach ($arguments as &$argument) {
            if ($argument->getClass() && is_a($argument->getClass()->name, 'Behat\Mink\Mink', true)) {
                $argument = $this->mink;
            }
        }

        return $arguments;
    }

    public function initialize(Suite $suite, Spec $spec)
    {
        $this->mink->setDefaultSessionName($suite->getSetting('mink_session'));
        $this->mink->resetSessions();
    }
}
