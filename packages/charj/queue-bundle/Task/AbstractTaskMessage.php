<?php

namespace Charj\QueueBundle\Task;

class AbstractTaskMessage
{
    private $command;
    private $arguments;

    /**
     * @return string
     */
    public function __toString() : string
    {
        return json_encode([
                'command' => $this->command,
                'arguments' => $this->arguments
            ]
        );
    }

    /**
     * @param string $command
     *
     * @return AbstractTaskMessage
     */
    public function setCommand(string $command) : AbstractTaskMessage
    {
        $this->command = $command;

        return $this;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @param array $arguments
     *
     * @return AbstractTaskMessage
     */
    public function setArguments($arguments) : AbstractTaskMessage
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions() : array
    {
        return $this->arguments;
    }
}