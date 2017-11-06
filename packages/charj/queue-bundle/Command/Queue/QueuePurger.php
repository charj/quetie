<?php

namespace Charj\QueueBundle\Command\Queue;

use Charj\QueueBundle\Command\PrettyConsoleOutputTrait;
use Charj\QueueBundle\Consumer\SqsConsumerTrait;
use Charj\QueueBundle\Exception\QueueConsumerException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class QueuePurger extends Command
{

    use PrettyConsoleOutputTrait;
    use SqsConsumerTrait;
    use QueueCommandRequirementTrait;

    protected function configure()
    {
        $this
            ->setName('charj:queue:purge')
            ->setDescription('Removes all items from specified queue.')
            ->addArgument(
                'name',
                InputOption::VALUE_REQUIRED,
                'The name of the queue',
                null
            );

        parent::configure();
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
        $queueName = $this->requireQueueName($input);

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('This is a destructive operation and will remove all items from given queue? [y/N]', false);

        if (!$helper->ask($input, $output, $question)) {
            return;
        }

        $this->sqsConsumer->purgeQueue($queueName);

        $output->writeln("Queue ($queueName) purged successfully.");
    }
}
