<?php

namespace Funk\Output\Formatter;

use Behat\Testwork\Output\Formatter;
use Symfony\Component\EventDispatcher\Event;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Testwork\Output\Printer\OutputPrinter;
use Behat\Testwork\Exception\ExceptionPresenter;

class Pretty implements Formatter
{
    private $printer;
    private $presenter;
    private $basePath;
    private $parameters = [];

    public function __construct(OutputPrinter $printer, ExceptionPresenter $presenter, $basePath)
    {
        $this->printer = $printer;
        $this->presenter = $presenter;
        $this->basePath = $basePath;
    }

    public function getName()
    {
        return 'pretty';
    }

    public function getDescription()
    {
        return 'prints the spec as a sentence';
    }

    public static function getSubscribedEvents()
    {
        return [
            'beforeSpec'   => 'printSpecName',
            'afterExample' => 'printExampleResult'
        ];
    }

    public function printSpecName(Event $event)
    {
        $this->printer->writeln();
        $spec = $event->getSubject();
        $fqcn = $spec->getReflection()->getName();
        $this->printer->writeln(sprintf('<spec>%s</spec>', str_replace(['\\', '_'], ' ', $fqcn)));
        $this->printer->writeln();
    }

    public function printExampleResult(Event $event)
    {
        $example = $event->getSubject();
        $title = str_replace('_', ' ', $example->getReflection()->getName());
        $result = $event->getArgument('result');

        switch ($result->getResultCode()) {
            case TestResult::PASSED:
                $this->printer->write(sprintf('<passed>✔ %s</passed>', $title));
                break;
            case TestResult::PENDING:
                $this->printer->write(sprintf('<pending>- %s</pending>', $title));
                break;
            case TestResult::FAILED:
                $this->printer->write(sprintf('<failed>✘ %s</failed>', $title));
                break;
            case TestResult::SKIPPED:
                $this->printer->write(sprintf('<skipped>! %s</skipped>', $title));
                break;
        }

        $path  = ltrim(str_replace($this->basePath, '', $example->getPath()), '/');
        $line  = $example->getReflection()->getStartLine();
        $this->printer->writeln(sprintf(' <comment>%s</comment> <lineno>+%d</lineno>', $path, $line));

        $this->printer->writeln($result->getStdOut());

        if ($result->hasException()) {
            $this->printer->writeln($this->presenter->presentException($result->getException()));
        }
    }

    public function getOutputPrinter()
    {
        return $this->printer;
    }

    public function getParameter($name)
    {
        return @$this->parameters[$name];
    }

    public function setParameter($name, $value)
    {
        $this->parameters[$name] = $value;
    }
}
