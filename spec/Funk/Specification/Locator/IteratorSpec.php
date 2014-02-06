<?php

namespace spec\Funk\Specification\Locator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Behat\Testwork\Suite\Suite;

class IteratorSpec extends ObjectBehavior
{
    function let(Suite $suite, \Iterator $files)
    {
    }

    function it_provides_iteration_over_all_it__methods($suite, $files)
    {
        $this->beConstructedWith($suite, $files, '/base/path');
    }
}
