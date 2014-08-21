<?php

namespace functional\developer\can\run;

use Funk\ApplicationFactory;
use Symfony\Component\Console\Tester\ApplicationTester;

class spec implements \Funk\Spec
{
    function it_runs_specs()
    {
        expect(shell_exec('bin/funk funk -s funk'))->toMatch('/✔/');
    }
}
