<?php

namespace Funk\Output\Formatter;

use Behat\Testwork\Output\CliFormatter;
use Symfony\Component\EventDispatcher\Event;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Testwork\Output\Printer\OutputPrinter;
use Behat\Testwork\Exception\ExceptionPresenter;

class Pretty extends CliFormatter
{
    private $basePath;

    public function __construct(OutputPrinter $printer, ExceptionPresenter $presenter, $basePath)
    {
        parent::__construct($printer, $presenter);
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
        $this->writeln();
        $spec = $event->getSubject();
        $fqcn = $spec->getReflection()->getName();
        $this->writeln(sprintf('<spec>%s</spec>', str_replace(['\\', '_'], ' ', $fqcn)));
        $this->writeln();
    }

    public function printExampleResult(Event $event)
    {
        $example = $event->getSubject();
        $title = str_replace('_', ' ', $example->getReflection()->getName());

        switch ($event->getArgument('result')->getResultCode()) {
            case TestResult::PASSED:
                $this->write(sprintf('<passed>✔ %s</passed>', $title));
                break;
            case TestResult::PENDING:
                $this->write(sprintf('<pending>- %s</pending>', $title));
                break;
            case TestResult::FAILED:
                $this->write(sprintf('<failed>✘ %s</failed>', $title));
                break;
            case TestResult::SKIPPED:
                $this->write(sprintf('<skipped>! %s</skipped>', $title));
                break;
        }

        $path  = ltrim(str_replace($this->basePath, '', $example->getPath()), '/');
        $line  = $example->getReflection()->getStartLine();
        $this->write(sprintf(' <comment>%s</comment> <lineno>+%d</lineno>', $path, $line));

        $this->writeln();

        $result = $event->getArgument('result');
        if ($result->hasException()) {
            $this->writeln($this->presentException($result->getException()));
        }
    }
}
