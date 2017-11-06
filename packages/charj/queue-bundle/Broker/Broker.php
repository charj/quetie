<?php

namespace Charj\QueueBundle\Broker;

use Charj\QueueBundle\Command\Task\EmailCommand;
use Charj\QueueBundle\Command\Task\ReportCommand;
use Charj\QueueBundle\Consumer\SqsConsumer;
use Charj\QueueBundle\Task\EmailTaskMessage;
use Charj\QueueBundle\Task\ReportTaskMessage;

class Broker
{
    private $sqsConsumer;

    /**
     * Broker constructor.
     *
     * @param SqsConsumer $sqsConsumer
     */
    public function __construct(SqsConsumer $sqsConsumer)
    {
        $this->sqsConsumer = $sqsConsumer;
    }

    /**
     * @param string $emailAddress
     */
    public function queueEmail(string $emailAddress)
    {
        $message = new EmailTaskMessage();
        $command = new EmailCommand();

        $message
            ->setCommand($command->getName())
            ->setArguments([
                '--to-email' => $emailAddress
            ]);

        $this->sqsConsumer->sendMessage(
            $message,
            'test-queue'
        );
    }

    /**
     * @param string $emailAddress
     */
    public function queueReport(string $emailAddress)
    {
        $message = new ReportTaskMessage();
        $command = new ReportCommand();

        $message
            ->setCommand($command->getName())
            ->setArguments([
                '--to-email' => $emailAddress,
                '--report-type' => 'an_example_report'
        ]);

        $this->sqsConsumer->sendMessage(
            $message,
            'test-queue'
        );
    }
}
