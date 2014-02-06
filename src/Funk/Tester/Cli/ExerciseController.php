<?php

namespace Funk\Tester\Cli;

use Behat\Testwork\Specification\SpecificationIterator;
use Behat\Testwork\Tester\Cli\ExerciseController as BaseController;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

class ExerciseController extends BaseController
{
    /**
     * Configures command to be executable by the controller.
     *
     * @param Command $command
     */
    public function configure(Command $command)
    {
        $command
            ->addArgument(
                'specs', InputArgument::REQUIRED,
                'spec directory to run'
            )
            ->addOption(
                '--dry-run', null, InputOption::VALUE_NONE,
                'Invokes formatters without executing the steps & hooks.'
            )
            ->addOption(
                '--strict', null, InputOption::VALUE_NONE,
                'Fail if there are any undefined or pending steps.'
            )
        ;
    }

    /**
     * Creates exercise spec iterators.
     *
     * @param InputInterface $input
     *
     * @return SpecificationIterator[]
     */
    protected function findSpecifications(InputInterface $input)
    {
        $specs = array();
        foreach ($this->getSpecLocators($input) as $locator) {
            $specs = array_merge($specs, $this->findSuitesSpecifications($this->getAvailableSuites(), $locator));
        }

        return $specs;
    }

    /**
     * Gets feature locators from input.
     *
     * @param InputInterface $input
     *
     * @return string[]
     */
    private function getSpecLocators(InputInterface $input)
    {
        return array($input->getArgument('specs'));
    }
}
