<?php

namespace Funk\Environment\Handler;

use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Environment\Handler\EnvironmentHandler;
use Funk\Environment\Spec as SpecEnvironment;
use Funk\Call\InvokableMethod;
use Funk\Initializer\Spec as SpecInitializer;
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
        $instance = $this->createInstance($environment->getSuite(), $method);
        $environment = new SpecEnvironment($environment->getSuite(), $instance);

        return $environment;
    }

    private function createInstance(Suite $suite, InvokableMethod $method)
    {
        $reflect = $method->getReflection()->getDeclaringClass();

        $arguments = $this->resolveArguments($suite, $reflect);
        $instance = $reflect->newInstanceArgs($arguments);

        foreach ($this->initializers as $initializer) {
            if (!$initializer->isSupported($suite, $reflect)) {
                continue;
            }
            $initializer->initialize($suite, $instance);
        }

        return $instance;
    }

    private function resolveArguments(Suite $suite, \ReflectionClass $reflect)
    {
        if (!$reflect->getConstructor()) {
            return [];
        }

        $arguments = [];
        foreach ($this->initializers as $initializer) {
            if (!$initializer->isSupported($suite, $reflect)) {
                continue;
            }
            $arguments = array_merge($arguments, $initializer->resolveArguments($suite, $reflect->getConstructor()));
        }

        foreach ($arguments as &$argument) {
            if ($argument instanceof \ReflectionParameter) {
                if (!$argument->isOptional()) {
                    throw new \RuntimeException(sprintf('Argument "%s" of %s::__construct is required, but has not been resolved.', $argument->name, $reflect->name));
                }

                $argument = $argument->getDefaultValue();
            }
        }

        return $arguments;
    }
}
