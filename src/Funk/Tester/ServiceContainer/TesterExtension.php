<?php

namespace Funk\Tester\ServiceContainer;

use Behat\Testwork\Call\ServiceContainer\CallExtension;
use Behat\Testwork\Cli\ServiceContainer\CliExtension;
use Behat\Testwork\Environment\ServiceContainer\EnvironmentExtension;
use Behat\Testwork\EventDispatcher\ServiceContainer\EventDispatcherExtension;
use Behat\Testwork\Specification\ServiceContainer\SpecificationExtension;
use Behat\Testwork\Suite\ServiceContainer\SuiteExtension;
use Behat\Testwork\Tester\ServiceContainer\TesterExtension as BaseExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Funk\Hook\ServiceContainer\HookExtension;
use Behat\Testwork\Autoloader\ServiceContainer\AutoloaderExtension;

class TesterExtension extends BaseExtension
{
    const SPEC_LOCATOR_ID = 'locator.spec';

    public function load(ContainerBuilder $container, array $config)
    {
        parent::load($container, $config);
        $this->loadAutoloadSuiteSetup($container);
    }

    /**
     * Loads exercise controller.
     *
     * @param ContainerBuilder $container
     * @param Boolean          $strict
     * @param Boolean          $skip
     */
    protected function loadExerciseController(ContainerBuilder $container, $strict = false, $skip = false)
    {
        $definition = new Definition('Funk\Tester\Cli\ExerciseController', array(
            new Reference(SuiteExtension::REGISTRY_ID),
            new Reference(SpecificationExtension::FINDER_ID),
            new Reference(self::EXERCISE_ID),
            $strict,
            $skip
        ));
        $definition->addTag(CliExtension::CONTROLLER_TAG, array('priority' => 0));
        $container->setDefinition(CliExtension::CONTROLLER_TAG . '.exercise', $definition);
    }

    /**
     * Loads Specification tester.
     *
     * @param ContainerBuilder $container
     */
    protected function loadSpecificationTester(ContainerBuilder $container)
    {
        $definition = new Definition('Funk\Tester\SpecTester', [
            new Reference(self::SPECIFICATION_TESTER.'.example.event_dispatcher'),
            new Reference(EventDispatcherExtension::DISPATCHER_ID),
        ]);
        $container->setDefinition(self::SPECIFICATION_TESTER, $definition);

        $definition = new Definition('Funk\Tester\ExampleTester\EventDispatcher', [
            new Reference(self::SPECIFICATION_TESTER.'.example.default'),
            new Reference(EventDispatcherExtension::DISPATCHER_ID),
        ]);
        $container->setDefinition(self::SPECIFICATION_TESTER.'.example.event_dispatcher', $definition);

        $definition = new Definition('Funk\Tester\ExampleTester\DefaultTester', [
            new Reference(EnvironmentExtension::MANAGER_ID),
            new Reference(CallExtension::CALL_CENTER_ID),
        ]);
        $container->setDefinition(self::SPECIFICATION_TESTER.'.example.default', $definition);

        $definition = new Definition('Funk\Specification\Locator\Spec', [
            '%paths.base%',
        ]);
        $definition->addTag(SpecificationExtension::LOCATOR_TAG);
        $container->setDefinition(self::SPEC_LOCATOR_ID, $definition);
    }

    private function loadAutoloadSuiteSetup(ContainerBuilder $container)
    {
        $definition = new Definition('Funk\Suite\Setup\Autoload', array(
            new Reference(AutoloaderExtension::CLASS_LOADER_ID),
        ));
        $definition->addTag(SuiteExtension::SETUP_TAG, array('priority' => 20));
        $container->setDefinition(SuiteExtension::SETUP_TAG . '.autoload', $definition);
    }
}
