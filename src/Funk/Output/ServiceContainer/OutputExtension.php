<?php

namespace Funk\Output\ServiceContainer;

use Behat\Behat\Definition\ServiceContainer\DefinitionExtension;
use Behat\Testwork\Exception\ServiceContainer\ExceptionExtension;
use Behat\Testwork\Output\ServiceContainer\OutputExtension as BaseExtension;
use Behat\Testwork\Translator\ServiceContainer\TranslatorExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class OutputExtension extends BaseExtension
{
    /**
     * Loads default formatters.
     *
     * @param ContainerBuilder $container
     */
    protected function loadFormatters(ContainerBuilder $container)
    {
        $this->loadPrettyFormatter($container);
    }

    /**
     * Returns default formatter name.
     *
     * @return string
     */
    protected function getDefaultFormatterName()
    {
        return 'pretty';
    }

    /**
     * Loads pretty formatter.
     *
     * @param ContainerBuilder $container
     */
    protected function loadPrettyFormatter(ContainerBuilder $container)
    {
        $definition = new Definition('Funk\Output\Formatter\Pretty', array(
            $this->createOutputPrinterDefinition(),
            new Reference(ExceptionExtension::PRESENTER_ID),
            '%paths.base%'
        ));
        $definition->addTag(self::FORMATTER_TAG, array('priority' => 100));
        $container->setDefinition(self::FORMATTER_TAG . '.pretty', $definition);
    }

    /**
     * Creates output printer definition.
     *
     * @return Definition
     */
    protected function createOutputPrinterDefinition()
    {
        $definition = new Definition('Behat\Testwork\Output\Printer\ConsoleOutputPrinter');
        $definition->addMethodCall('setOutputStyles', [
            [
                'failed'  => ['red'],
                'passed'  => ['green'],
                'spec'    => ['yellow'],
                'comment' => ['cyan'],
                'lineno'  => ['yellow'],
                //black, red, green, yellow, blue, magenta, cyan, white
            ]
        ]);


        return $definition;
    }
}
