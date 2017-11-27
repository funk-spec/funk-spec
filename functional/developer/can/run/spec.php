<?php

namespace functional\developer\can\run;

use Funk\ApplicationFactory;
use Symfony\Component\Console\Tester\ApplicationTester;

class spec implements \Funk\Spec
{
    function it_runs_specs()
    {
        if (false === mb_strpos(shell_exec('bin/funk funk -s funk'), '✔')) {
            throw new \Exception;
        }
    }
}
