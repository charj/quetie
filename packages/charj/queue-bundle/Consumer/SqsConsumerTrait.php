<?php

namespace Charj\QueueBundle\Consumer;

trait SqsConsumerTrait
{
    private $sqsConsumer;

    public function __construct(SqsConsumer $sqsConsumer)
    {
        $this->sqsConsumer = $sqsConsumer;
        parent::__construct();
    }
}
