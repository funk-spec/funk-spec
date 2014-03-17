<?php

namespace Funk\Environment\Handler;

use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Environment\Handler\EnvironmentHandler;
use Funk\Environment\Spec as SpecEnvironment;
use Funk\Call\InvokableMethod;
use Funk\Initializer\SpecInitializer;
use Behat\Testwork\Suite\Suite;

class Spec implements EnvironmentHandler
{
    private $initializers = [];

    public function registerInitializer(SpecInitializer $initializer)
    {
        $this->initializers[] = $initializer;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsSuite(Suite $suite)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function buildEnvironment(Suite $suite)
    {
        return new SpecEnvironment($suite);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsEnvironmentAndSubject(Environment $environment, $testSubject = null)
    {
        return $environment instanceof SpecEnvironment;
    }

    public function isolateEnvironment(Environment $environment, $method = null)
    {
        $instance = $this->createInstance($method);
        $environment = new SpecEnvironment($environment->getSuite(), $instance);

        return $environment;
    }

    public function createInstance(InvokableMethod $method)
    {
        $instance = $method->getReflection()->getDeclaringClass()->newInstance();

        foreach ($this->initializers as $initializer) {
            $initializer->initializeSpec($instance);
        }

        return $instance;
    }
}
