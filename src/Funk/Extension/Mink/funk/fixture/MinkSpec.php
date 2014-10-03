<?php

namespace funk\fixture;

use Behat\Mink\Mink;

class MinkSpec implements \Funk\Spec
{
    private $mink;

    public function __construct(Mink $mink = null)
    {
        $this->mink = $mink;
    }

    public function it_uses_mink()
    {
        expect($this->mink)->toHaveType('Behat\Mink\Mink');
        var_dump($this->mink->getSession()->getDriver()->getWebDriverSession()->capabilities());
    }
}
