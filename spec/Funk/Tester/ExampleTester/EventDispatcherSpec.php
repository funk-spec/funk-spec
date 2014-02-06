<?php

namespace spec\Funk\Tester\ExampleTester;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Funk\Tester\ExampleTester;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Behat\Testwork\Environment\Environment;
use Funk\Call\InvokableMethod;

class EventDispatcherSpec extends ObjectBehavior
{
    function let(ExampleTester $tester, EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($tester, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Funk\Tester\ExampleTester\EventDispatcher');
    }

    function it_dispatches_example_event($dispatcher, Environment $env, InvokableMethod $example)
    {
        $dispatcher->dispatch('beforeExample', Argument::type('Symfony\Component\EventDispatcher\GenericEvent'))->shouldBeCalled();
        $dispatcher->dispatch('afterExample', Argument::type('Symfony\Component\EventDispatcher\GenericEvent'))->shouldBeCalled();
        $this->test($env, $example);
    }
}
