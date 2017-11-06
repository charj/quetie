<?php

namespace Charj\QueueBundle\Consumer;

use Aws\Result;
use Aws\Sqs\SqsClient;
use Charj\QueueBundle\Task\AbstractTaskMessage;

class SqsConsumer
{
    private $sqsClient;

    public function __construct(SqsClient $sqsClient)
    {
        $this->sqsClient = $sqsClient;
    }

    /**
     * @param AbstractTaskMessage $message
     * @param $queue
     *
     * @return \Aws\Result
     * @throws \Exception
     * @internal param $body
     */
    public function sendMessage(AbstractTaskMessage $message, $queue)
    {
        $this->createQueue($queue);
        return $this->sqsClient->sendMessage([
            'DelaySeconds' => 0,
            'MessageBody' => (string) $message,
            'QueueUrl' => $this->getQueueUrl($queue)
        ]);
    }

    /**
     * @param string $name
     * @param int $maxNumberOfMessages
     *
     * @return \Aws\Result
     */
    public function receiveMessages(string $name, $maxNumberOfMessages = 10)
    {
        return $this->sqsClient->receiveMessage([
            'MaxNumberOfMessages' => $maxNumberOfMessages,
            'QueueUrl' => $this->getQueueUrl($name)
        ])->get('Messages');
    }

    /**
     * @param $name
     *
     * @return \Aws\Result
     */
    public function createQueue($name) : Result
    {
        return $this->sqsClient->createQueue([
            'QueueName' => $name
        ]);
    }

    /**
     * @param $name
     *
     * @return string
     */
    public function getQueueUrl($name) : string
    {
        return $this->sqsClient->getQueueUrl([
            'QueueName' => $name
        ])->get('QueueUrl');
    }


    /**
     * @param $url
     *
     * @return string
     */
    public function getQueueArn($url) : string
    {
        return $this->sqsClient->getQueueArn($url);
    }

    /**
     * @param $url
     *
     * @return string
     */
    public function getQueueName($url) : string
    {
        $queueName = explode(':', $this->getQueueArn($url));
        return end($queueName);
    }
    /**
     * @return array
     */
    public function listQueueUrls() : array
    {
        return $this->sqsClient->listQueues()->get('QueueUrls');
    }

    /**
     * @param $name
     *
     * @return \Aws\Result
     */
    public function purgeQueue($name) : Result
    {
        return $this->sqsClient->purgeQueue(
            ['QueueUrl' => $this->getQueueUrl($name)]
        );
    }
}
