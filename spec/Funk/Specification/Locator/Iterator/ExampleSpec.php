<?php

namespace spec\Funk\Specification\Locator\Iterator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Behat\Testwork\Suite\Suite;
use Funk\Specification\Locator\Iterator\Spec;

class ExampleSpec extends ObjectBehavior
{
    function let(Suite $suite, Spec $spec, \ReflectionClass $refl)
    {
        $spec->getReflection()->willReturn($refl);
        $this->beConstructedWith($suite, $spec);
    }

    function it_iterates_over__it_methods($refl, \ReflectionMethod $it_does, \ReflectionMethod $doh, \ReflectionMethod $it_does_not)
    {
        $it_does->getName()->willReturn('it_does');
        $it_does_not->getName()->willReturn('it_does_not');
        $doh->getName()->willReturn('doh');
        $refl->getMethods(Argument::any())->willReturn([
            $it_does, $doh, $it_does_not,
        ]);

        $this->current()->shouldHaveType('Funk\Call\InvokableMethod');
        $this->shouldHaveCount(2);
    }
}
