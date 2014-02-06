<?php

namespace spec\Funk\Tester\Result;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExampleTestResultSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Funk\Tester\Result\ExampleTestResult');
    }
}
