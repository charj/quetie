<?php

namespace Charj\QueueBundle\Command\Queue;

use Charj\QueueBundle\Exception\QueueConsumerException;
use Symfony\Component\Console\Input\InputInterface;

trait QueueCommandRequirementTrait
{
    /**
     * @param InputInterface $input
     *
     * @return static
     * @throws QueueConsumerException
     */
    public function requireQueueName(InputInterface $input)
    {
        // Check if queue name argument is passed in
        if (! $queueName = $input->getArgument('name')) {
            throw new QueueConsumerException('Queue name is not set. It\'s required when running the QueueConsumer Command');
        }

        return $queueName;
    }
}