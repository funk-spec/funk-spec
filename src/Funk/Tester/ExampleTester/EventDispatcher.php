<?php

namespace Funk\Tester\ExampleTester;

use Funk\Tester\ExampleTester;
use Behat\Testwork\Environment\Environment;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class EventDispatcher implements ExampleTester
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
        $this->dispatcher->dispatch('beforeExample', new GenericEvent($spec));
        $result = $this->tester->test($environment, $spec, $skip);
        $this->dispatcher->dispatch('afterExample', new GenericEvent($spec, ['result' => $result]));

        return $result;
    }
}
