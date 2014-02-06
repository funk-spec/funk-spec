<?php

namespace Funk\Tester\ExampleTester;

use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Environment\EnvironmentManager;
use Behat\Testwork\Environment\Call\EnvironmentCall;
use Behat\Testwork\Call\CallCenter;
use Funk\Tester\ExampleTester;
use Funk\Tester\Result\ExampleTestResult;

class DefaultTester implements ExampleTester
{
    private $environmentManager;
    private $callCenter;

    public function __construct(EnvironmentManager $environmentManager, CallCenter $callCenter)
    {
        $this->environmentManager = $environmentManager;
        $this->callCenter = $callCenter;
    }

    public function test(Environment $environment, $example, $skip = false)
    {
        $callResult = $this->callCenter->makeCall(new EnvironmentCall(
            $environment,
            $example,
            []
        ));

        return new ExampleTestResult($callResult);
    }
}
