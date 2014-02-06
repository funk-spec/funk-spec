<?php

namespace functional\developer\can\run;

use Funk\ApplicationFactory;
use Symfony\Component\Console\Tester\ApplicationTester;

class spec implements \Funk\Spec
{
    function it_runs_specs()
    {
        $factory = new ApplicationFactory;
        $app = $factory->createApplication();
        $app->setAutoExit(false);
        $tester = new ApplicationTester($app);
        $tester->run(['funk']);

        expect($tester->getDisplay())->toMatch('/passed/');
    }
}
