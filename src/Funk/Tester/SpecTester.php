<?php

namespace Funk\Tester;

use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Tester\Result\TestResults;
use Behat\Testwork\Tester\SpecificationTester;
use Funk\Tester\ExampleTester;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

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
}
