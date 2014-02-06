<?php

namespace spec\Funk\Specification\Locator\Iterator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Behat\Testwork\Suite\Suite;

class SpecSpec extends ObjectBehavior
{
    function let(\SplFileInfo $file, Suite $suite)
    {
        $file->getFilename()->willReturn(__FILE__);
        $file->getPath()->willReturn(__DIR__);
        $file->getBasename('.php')->willReturn('SpecSpec');
        $this->beConstructedWith($file, $suite, realpath(__DIR__.'/../../../../..'));
        $this->shouldHaveType('Funk\Specification\Locator\Iterator\Spec');
    }

    public function it_reflects_class_corrseponding_file()
    {
        $this->getReflection()->shouldHaveType('ReflectionClass');
    }
}
