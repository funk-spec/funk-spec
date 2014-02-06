<?php

namespace spec\Funk\Tester;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Funk\Tester\ExampleTester;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Behat\Testwork\Environment\Environment;
use Funk\Specification\Locator\Iterator\Spec;
use Funk\Call\InvokableMethod;

class SpecTesterSpec extends ObjectBehavior
{
    public function let(ExampleTester $tester, EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($tester, $dispatcher);
    }

    function it_dispatches_beforeSpec_events(Environment $env, Spec $spec, $dispatcher, InvokableMethod $method)
    {
        $dispatcher->dispatch('beforeSpec', Argument::type('Symfony\Component\EventDispatcher\GenericEvent'))->shouldBeCalled();
        $dispatcher->dispatch('afterSpec', Argument::type('Symfony\Component\EventDispatcher\GenericEvent'))->shouldBeCalled();
        $spec->getExamples()->willReturn($method);
        $this->test($env, $spec);
    }
}
