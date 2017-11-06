<?php

namespace Charj\QueueBundle\Command\Task;

use Charj\QueueBundle\Command\PrettyConsoleOutputTrait;
use Charj\QueueBundle\Exception\QueueConsumerException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class ReportCommand extends Command
{
    use PrettyConsoleOutputTrait;

    public function configure()
    {
        $this
            ->setName('charj:task:report')
            ->addOption(
                'to-email',
                'te',
                InputOption::VALUE_REQUIRED,
                'The email address of the recipient'
            )
            ->addOption(
                'report-type',
                'rt',
                InputOption::VALUE_REQUIRED,
                'The report type we need to generate'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws QueueConsumerException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Running Report Generator',
            self::$blankSeparator
        ]);
    }
}
