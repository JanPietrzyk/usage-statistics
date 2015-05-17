<?php


namespace Jpietrzyk\UsageStatistics\Handler;

/**
 * Class MessageResponse
 *
 * Abstraction for output
 *
 * @package Jpietrzyk\UsageStatistics\Handler
 */
class MessageResponse
{

    /**
     * @var string[]
     */
    private $messages = [];

    /**
     * @param string $message
     */
    public function addMessage($message)
    {
        $this->messages[] = $message;
    }

    /**
     * @return string[]
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
