<?php

namespace Funk\Initializer;

use Funk\Spec as Subject;
use Behat\Testwork\Suite\Suite;

interface Spec
{
    public function isSupported(Suite $suite, \ReflectionClass $subject);

    /**
     * @return array the resolved arguments used for instantiation
     **/
    public function resolveArguments(Suite $suite, \ReflectionMethod $constructor);

    /**
     * modifies the newly created instance
     **/
    public function initialize(Suite $suite, Subject $spec);
}
