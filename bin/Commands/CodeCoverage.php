<?php

namespace bin\Cmp\FeatureBalancer\Commands;

use PHP_CodeCoverage;
use PHP_CodeCoverage_Filter;
use PHP_CodeCoverage_Report_Clover;
use PhpSpec\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class CodeCoverage extends Command
{
    /**
     * @var string
     */
    private $baseDir;

    /**
     * @var int
     */
    private $exitCode = 0;

    protected function configure()
    {
        $this->baseDir = realpath(__DIR__.'/..').'/';

        $this->setName('code-coverage:run')
            ->setDescription('Runs the code coverage');
    }

    /**
     * Builds the code coverage clove report file
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $coverage = new PHP_CodeCoverage(null, $this->getFilter());
        $coverage->start('<tests>');

        $this->runPhpSpec();

        $coverage->stop();
        $this->writeReport($coverage);

        return $this->exitCode;
    }

    /**
     * Writes the clover report
     *
     * @param PHP_CodeCoverage $coverage
     */
    private function writeReport(PHP_CodeCoverage $coverage)
    {
        $writer = new PHP_CodeCoverage_Report_Clover();
        $writer->process($coverage, $this->getPath('clover.xml'));
    }

    /**
     * Runs php spec unit tests
     */
    private function runPhpSpec()
    {
        $input = new ArgvInput(['phpspec', 'run', '--format=pretty']);
        $app = new Application(null);
        $app->setAutoExit(false);

        $this->exitCode = $app->run($input, new ConsoleOutput());
    }

    /**
     * @return PHP_CodeCoverage_Filter
     */
    private function getFilter()
    {
        $filter = new PHP_CodeCoverage_Filter();
        $filter->addDirectoryToWhitelist($this->getPath('src'));
        $filter->addDirectoryToBlacklist($this->getPath('test'));
        $filter->addDirectoryToBlacklist($this->getPath('vendor'));

        return $filter;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private function getPath($path)
    {
        return $this->baseDir.$path;
    }
}