<?php

namespace Funk\Extension\Mink;

use Behat\Testwork\ServiceContainer;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Behat\MinkExtension\ServiceContainer\MinkExtension;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Funk\Tester\ServiceContainer\TesterExtension;

final class Extension implements ServiceContainer\Extension
{
    public function getConfigKey()
    {
        return 'funk_mink';
    }

    public function initialize(ExtensionManager $extensionManager)
    {
    }

    public function configure(ArrayNodeDefinition $builder)
    {
    }

    public function process(ContainerBuilder $container)
    {
    }

    public function load(ContainerBuilder $container, array $config)
    {
        $definition = new Definition('Funk\Extension\Mink\Initializer', [new Reference(MinkExtension::MINK_ID)]);
        $definition->addTag(TesterExtension::INITIALIZER_TAG);
        $container->setDefinition(TesterExtension::INITIALIZER_TAG . '.mink', $definition);
    }
}
