<?php

namespace RiotQuest\Contracts;

use Exception;
use RiotQuest\Components\Client\Application;
use Throwable;

/**
 * Class LeagueException
 *
 * Named Exception namespace for all exceptions
 * thrown by RiotQuest
 *
 * @package RiotQuest\Contracts
 */
class LeagueException extends Exception
{

    /**
     * Data to hold onto, like an API error message
     *
     * @var null
     */
    private $data;

    /**
     * LeagueException constructor.
     *
     * Allows for passing an additional data set as a fourth parameter to give a more verbose
     * description of the error.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param null $data
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null, $data = null)
    {
        Application::log('CRITICAL', $message);
        $this->data = $data;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the context of this error, if any
     *
     * @return mixed|null
     */
    public function getContext()
    {
        return $this->data;
    }

    /**
     * @return string|void
     */
    public function __toString()
    {
        return
            "A RiotQuest LeagueException has been thrown.
             Match the given error code with the ones described 
             at (https://riotquest.supergrecko.dev/docs/exceptions/) 
             for a more verbose description.
             
             $this->message
             ";
    }

}
