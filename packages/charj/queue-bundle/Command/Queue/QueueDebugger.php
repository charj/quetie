<?php

namespace Charj\QueueBundle\Command\Queue;

use Charj\QueueBundle\Command\PrettyConsoleOutputTrait;
use Charj\QueueBundle\Consumer\SqsConsumerTrait;
use Charj\QueueBundle\Exception\QueueConsumerException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueueDebugger extends Command
{
    use PrettyConsoleOutputTrait;
    use SqsConsumerTrait;

    protected function configure()
    {
        $this
            ->setName('charj:queue:debug')
            ->setDescription('For debugging use only. It dumps out some useful stuff.');

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
        $queueUrls = $this->sqsConsumer->listQueueUrls();

        foreach ($queueUrls as $queueUrl) {
            $queueNames[] = $this->sqsConsumer->getQueueName($queueUrl);
        }

        if (! isset($queueNames)) {
            $output->writeln('0 queues found.');
        }

        foreach ($queueNames as $queueName) {
            $this->sqsConsumer->receiveMessages($queueName, 10);
        }

    }
}
