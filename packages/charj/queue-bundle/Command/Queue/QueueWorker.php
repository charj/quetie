<?php

namespace Charj\QueueBundle\Command\Queue;

use Charj\QueueBundle\Command\PrettyConsoleOutputTrait;
use Charj\QueueBundle\Consumer\SqsConsumerTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class QueueWorker extends Command
{
    use PrettyConsoleOutputTrait;
    use SqsConsumerTrait;
    use QueueCommandRequirementTrait;

    protected function configure()
    {
        $this
            ->setName('charj:queue:run-worker')
            ->setDescription('Runs the worker for specified queue.')
            ->addArgument(
                'name',
                InputOption::VALUE_REQUIRED,
                'The name of the queue',
                null
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $queueName = $this->requireQueueName($input);
        $queueUrl = $this->sqsConsumer->getQueueUrl($queueName);
        $this->sqsConsumer->createQueue($queueName);
        $messages = $this->sqsConsumer->receiveMessages($queueName);

        $output->writeln(self::$lineSeparator);
        $output->writeLn(['Reading queue: '. $queueName , self::$lineSeparator]);
        $output->writeLn(['Number of messages found: '. $messageCount = count($messages), self::$lineSeparator]);

        if($messageCount <= 0) {
            return;
        }

        foreach ($messages as $message) {
            $messageBody = json_decode($message['Body'], true);

            $commandInput = new ArrayInput($messageBody['arguments']);
            $command = $this->getApplication()->find($messageBody['command']);
            $command->run($commandInput, $output);

            $this->sqsConsumer->deleteMessage($queueUrl, $message['ReceiptHandle']);
        }
    }
}
