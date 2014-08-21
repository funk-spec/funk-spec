<?php

namespace funk;

use Funk\Spec;

class TestSpec implements Spec
{
    function it_should_fail()
    {
        throw new \LogicException;
    }

    function it_should_pass()
    {
    }
}
