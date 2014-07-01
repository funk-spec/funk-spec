<?php

namespace Funk;

use Behat\Testwork\ApplicationFactory as Base;
use Behat\Testwork\Call\ServiceContainer\CallExtension;
use Behat\Testwork\Cli\ServiceContainer\CliExtension;
use Behat\Testwork\Environment\ServiceContainer\EnvironmentExtension;
use Behat\Testwork\EventDispatcher\ServiceContainer\EventDispatcherExtension;
use Behat\Testwork\Exception\ServiceContainer\ExceptionExtension;
use Behat\Testwork\Filesystem\ServiceContainer\FilesystemExtension;
use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ServiceProcessor;
use Behat\Testwork\Suite\ServiceContainer\SuiteExtension;
use Behat\Testwork\Hook\ServiceContainer\HookExtension;
use Behat\Testwork\Specification\ServiceContainer\SpecificationExtension;
use Behat\Testwork\Autoloader\ServiceContainer\AutoloaderExtension;
use Funk\Tester\ServiceContainer\TesterExtension;
use Behat\Testwork\Output\ServiceContainer\OutputExtension;

class ApplicationFactory extends Base
{
    const VERSION = '0.1-dev';

    /**
     * Returns application name.
     *
     * @return string
     */
    protected function getName()
    {
        return 'funk';
    }

    /**
     * Returns current application version.
     *
     * @return string
     */
    protected function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Returns list of extensions enabled by default.
     *
     * @return Extension[]
     */
    protected function getDefaultExtensions()
    {
        $processor = new ServiceProcessor;

        return array(
            // Testwork extensions
            new CliExtension($processor),
            new CallExtension($processor),
            new SuiteExtension($processor),
            new EnvironmentExtension($processor),
            new SpecificationExtension($processor),
            new EventDispatcherExtension($processor),
            new FilesystemExtension($processor),
            new ExceptionExtension($processor),
            new HookExtension($processor),
            new AutoloaderExtension(['%paths.base%/funk']),
            new OutputExtension('pretty', [new \Funk\Output\Formatter\Factory\Pretty]),

            // Funk extensions
            new TesterExtension($processor),
        );
    }

    /**
     * Returns the name of configuration environment variable.
     *
     * @return string
     */
    protected function getEnvironmentVariableName()
    {
        return 'FUNK';
    }

    /**
     * Returns user config path.
     *
     * @return null|string
     */
    protected function getConfigPath()
    {
        $cwd = rtrim(getcwd(), '/');
        $paths = array_filter(
            array(
                $cwd . '/' . 'funk.yml',
                $cwd . '/' . 'funk.yml.dist',
                $cwd . '/' . 'config' . '/' . 'funk.yml',
                $cwd . '/' . 'config' . '/' . 'funk.yml.dist',
            ),
            'is_file'
        );

        if (count($paths)) {
            return current($paths);
        }

        return null;
    }
}

