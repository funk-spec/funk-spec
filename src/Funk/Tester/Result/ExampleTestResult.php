<?php

namespace Funk\Tester\Result;

use Behat\Testwork\Call\CallResult;
use Exception;
use Behat\Testwork\Tester\Result\TestResult;

class ExampleTestResult extends TestResult
{
    /**
     * @var null|CallResult
     */
    private $callResult;

    public function __construct(CallResult $callResult = null)
    {
        $this->callResult = $callResult;
    }

    public function getException()
    {
        if ($this->callResult->hasException()) {
            return $this->callResult->getException();
        }
    }

    public function hasException()
    {
        return $this->callResult->hasException();
    }

    /**
     * Returns tester result status.
     *
     * @return integer
     */
    public function getResultCode()
    {
        if (null === $this->callResult) {
            return static::SKIPPED;
        }
        if ($this->callResult->getException() instanceof PendingException) {
            return static::PENDING;
        }
        if ($this->callResult->hasException()) {
            return static::FAILED;
        }

        return static::PASSED;
    }
}
