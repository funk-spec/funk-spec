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
use Behat\Testwork\ServiceContainer\ServiceProcessor;

class TesterExtension extends BaseExtension
{
    const SPEC_LOCATOR_ID = 'locator.spec';
    const INITIALIZER_TAG = 'spec.initializer';

    private $processor;

    public function __construct(ServiceProcessor $processor = null)
    {
        parent::__construct($processor);
        $this->processor = $processor ? : new ServiceProcessor;
    }

    public function load(ContainerBuilder $container, array $config)
    {
        parent::load($container, $config);
        $this->loadEnvironmentHandler($container);
    }

    public function process(ContainerBuilder $container)
    {
        parent::process($container);
        $this->loadInitializers($container);
    }

    /**
     * Loads Specification tester.
     *
     * @param ContainerBuilder $container
     */
    protected function loadSpecificationTester(ContainerBuilder $container)
    {
        $definition = new Definition('Funk\Tester\SpecTester', [
            new Reference(self::SPECIFICATION_TESTER_ID.'.example.event_dispatcher'),
            new Reference(EventDispatcherExtension::DISPATCHER_ID),
        ]);
        $container->setDefinition(self::SPECIFICATION_TESTER_ID, $definition);

        $definition = new Definition('Funk\Tester\ExampleTester\EventDispatcher', [
            new Reference(self::SPECIFICATION_TESTER_ID.'.example.default'),
            new Reference(EventDispatcherExtension::DISPATCHER_ID),
        ]);
        $container->setDefinition(self::SPECIFICATION_TESTER_ID.'.example.event_dispatcher', $definition);

        $definition = new Definition('Funk\Tester\ExampleTester\DefaultTester', [
            new Reference(EnvironmentExtension::MANAGER_ID),
            new Reference(CallExtension::CALL_CENTER_ID),
        ]);
        $container->setDefinition(self::SPECIFICATION_TESTER_ID.'.example.default', $definition);

        $definition = new Definition('Funk\Specification\Locator\Spec', [
            '%paths.base%',
        ]);
        $definition->addTag(SpecificationExtension::LOCATOR_TAG);
        $container->setDefinition(self::SPEC_LOCATOR_ID, $definition);
    }

    private function loadEnvironmentHandler(ContainerBuilder $container)
    {
        $definition = new Definition('Funk\Environment\Handler\Spec');
        $definition->addTag(EnvironmentExtension::HANDLER_TAG, array('priority' => 50));
        $container->setDefinition(EnvironmentExtension::HANDLER_TAG . '.spec', $definition);
    }

    public function loadInitializers(ContainerBuilder $container)
    {
        $definition = $container->getDefinition(EnvironmentExtension::HANDLER_TAG . '.spec');
        $references = $this->processor->findAndSortTaggedServices($container, self::INITIALIZER_TAG);
        foreach ($references as $reference) {
            $definition->addMethodCall('registerInitializer', array($reference));
        }
    }
}
