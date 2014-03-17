<?php

namespace Funk\Tester\ExampleTester;

use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Environment\EnvironmentManager;
use Behat\Testwork\Environment\Call\EnvironmentCall;
use Behat\Testwork\Call\CallCenter;
use Funk\Tester\ExampleTester;
use Funk\Tester\Result\ExampleTestResult;
use Funk\Call\InvokableMethod;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Testwork\Tester\Setup\SuccessfulTeardown;
use Behat\Testwork\Tester\Setup\SuccessfulSetup;

class DefaultTester implements ExampleTester
{
    private $environmentManager;
    private $callCenter;

    public function __construct(EnvironmentManager $environmentManager, CallCenter $callCenter)
    {
        $this->environmentManager = $environmentManager;
        $this->callCenter = $callCenter;
    }

    public function setUp(Environment $env, $spec, $skip)
    {
        return new SuccessfulSetup;
    }

    public function tearDown(Environment $env, $spec, $skip, TestResult $result)
    {
        return new SuccessfulTeardown;
    }

    public function test(Environment $environment, $example, $skip = false)
    {
        $environment = $this->environmentManager->isolateEnvironment($environment, $example);

        $callResult = $this->callCenter->makeCall(new EnvironmentCall(
            $environment,
            $example,
            []
        ));

        return new ExampleTestResult($callResult);
    }
}
