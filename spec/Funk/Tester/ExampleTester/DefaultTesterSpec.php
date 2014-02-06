<?php

namespace spec\Funk\Tester\ExampleTester;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Behat\Testwork\Environment\EnvironmentManager;
use Behat\Testwork\Call\CallCenter;
use Behat\Testwork\Environment\Environment;
use Funk\Call\InvokableMethod;

class DefaultTesterSpec extends ObjectBehavior
{
    function let(EnvironmentManager $em, CallCenter $cc)
    {
        $this->beConstructedWith($em, $cc);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Funk\Tester\ExampleTester\DefaultTester');
    }

    function it_returns_example_result(Environment $env, InvokableMethod $example)
    {
        $this->test($env, $example)->shouldHaveType('Funk\Tester\Result\ExampleTestResult');
    }
}
