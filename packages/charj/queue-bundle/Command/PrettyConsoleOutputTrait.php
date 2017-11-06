<?php

namespace Charj\QueueBundle\Command;

/**
 * Trait PrettyConsoleOutputTrait
 *
 * This trait is to reduce ugly duplication in command files and make output of commands consistent.
 *
 * @package Charj\QueueBundle\Command
 */
trait PrettyConsoleOutputTrait
{
    public static $lineSeparator = "========================";
    public static $blankSeparator = "                       ";
}
