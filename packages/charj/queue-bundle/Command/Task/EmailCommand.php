<?php

namespace Charj\QueueBundle\Command\Task;

use Charj\QueueBundle\Command\PrettyConsoleOutputTrait;
use Charj\QueueBundle\Exception\QueueConsumerException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class EmailCommand extends Command
{
    use PrettyConsoleOutputTrait;

    public function configure()
    {
        $this
            ->setName('charj:task:email')
            ->addOption(
                'to-email',
                'te',
                InputOption::VALUE_REQUIRED,
                'The email address of the recipient'
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
            'Sent Email to: ' . $input->getOption('to-email'),
            self::$blankSeparator
        ]);
    }
}
