<?php

namespace Funk\Tester;

use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Tester\Result\TestResults;
use Behat\Testwork\Tester\SpecificationTester;
use Funk\Tester\ExampleTester;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Testwork\Tester\Setup\SuccessfulSetup;
use Behat\Testwork\Tester\Setup\SuccessfulTeardown;

class SpecTester implements SpecificationTester
{
    private $tester;
    private $dispatcher;

    public function __construct(ExampleTester $tester, EventDispatcherInterface $dispatcher)
    {
        $this->tester = $tester;
        $this->dispatcher = $dispatcher;
    }

    public function test(Environment $environment, $spec, $skip = false)
    {
        $results = [];
        $this->dispatcher->dispatch('beforeSpec', new GenericEvent($spec));
        foreach ($spec->getExamples() as $example) {
            $results[] = $this->tester->test($environment, $example, $skip);
        }
        $this->dispatcher->dispatch('afterSpec', new GenericEvent($spec));

        return new TestResults($results);
    }

    public function setUp(Environment $env, $spec, $skip)
    {
        return new SuccessfulSetup;
    }

    public function tearDown(Environment $env, $spec, $skip, TestResult $result)
    {
        return new SuccessfulTeardown;
    }
}
