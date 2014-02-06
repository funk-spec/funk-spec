<?php

namespace spec\Funk\Output\Formatter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Behat\Testwork\Output\Printer\OutputPrinter;
use Behat\Testwork\Exception\ExceptionPresenter;
use Funk\Call\InvokableMethod;
use Funk\Tester\Result\ExampleTestResult;
use Symfony\Component\EventDispatcher\GenericEvent;
use Behat\Testwork\Tester\Result\TestResult;
use Funk\Specification\Locator\Iterator\Spec;

class PrettySpec extends ObjectBehavior
{
    function let(
        OutputPrinter $printer,
        ExceptionPresenter $ep,
        GenericEvent $event,
        InvokableMethod $method,
        \ReflectionMethod $refl,
        ExampleTestResult $result
    )
    {
        $this->beConstructedWith($printer, $ep, '/current/path');
        $event->getSubject()->willReturn($method);
        $event->getArgument('result')->willReturn($result);
        $method->getReflection()->willReturn($refl);
        $method->getPath()->willReturn('/current/path/to/spec');
        $refl->getName()->willReturn('it_does_stuff');
        $refl->getStartLine()->willReturn(42);
        $printer->write(' <comment>to/spec</comment> <lineno>+42</lineno>')->willReturn();
    }

    function it_prints_spec_name($event, Spec $spec, \ReflectionClass $refl, $result, $printer)
    {
        $printer->writeln('')->shouldBeCalledTimes(2);
        $event->getSubject()->willReturn($spec);
        $spec->getReflection()->willReturn($refl);
        $refl->getName()->willReturn('A\Very\Useful\Namespace');
        $printer->writeln('<spec>A Very Useful Namespace</spec>')->shouldBeCalled();
        $this->printSpecName($event);
    }

    function it_prints_failures_in_red($event, $method, $result, $printer)
    {
        $result->hasException()->willReturn(false);
        $result->getResultCode()->willReturn(TestResult::FAILED);
        $printer->write('<failed>✘ it does stuff</failed>')->shouldBeCalled();
        $printer->writeln('')->shouldBeCalled();
        $this->printExampleResult($event);
    }

    function it_prints_passed_in_green($event, $method, $result, $printer)
    {
        $result->hasException()->willReturn(false);
        $result->getResultCode()->willReturn(TestResult::PASSED);
        $printer->write('<passed>✔ it does stuff</passed>')->shouldBeCalled();
        $printer->writeln('')->shouldBeCalled();
        $this->printExampleResult($event);
    }

    function it_prints_exception($event, $method, $result, $printer, $ep, \Exception $exception)
    {
        $result->hasException()->willReturn(true);
        $result->getException()->willReturn($exception);
        $result->getResultCode()->willReturn(TestResult::FAILED);
        $printer->write('<failed>✘ it does stuff</failed>')->shouldBeCalled();
        $printer->writeln('')->shouldBeCalled();
        $printer->getOutputVerbosity()->willReturn(1);

        $ep->presentException($exception, 1)->shouldBeCalled()->willReturn('fail!');
        $printer->writeln('fail!')->shouldBeCalled();

        $this->printExampleResult($event);
    }
}
