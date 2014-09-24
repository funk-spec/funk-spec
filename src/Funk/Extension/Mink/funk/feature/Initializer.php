<?php

namespace funk\feature;

class Initializer implements \Funk\Spec
{
    function it_benefits_from_mink_sessions()
    {
        expect(shell_exec('bin/funk funk/fixture/MinkSpec.php'))->toMatch('/(ie9|ie10|ie11|ff|chrome)/');
    }
}
