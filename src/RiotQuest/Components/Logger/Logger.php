<?php

namespace RiotQuest\Components\Logger;

use Psr\Log\LoggerInterface;
use RiotQuest\Components\Engine\Utils;

/**
 * Class Logger
 * @package RiotQuest\Components\Logger
 */
class Logger implements LoggerInterface
{

    /**
     * @param string $message
     * @param array $context
     */
    public function emergency($message, array $context = array())
    {
        $this->write(Utils::replace($message, $context), 'EMERGENCY');
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function alert($message, array $context = array())
    {
        $this->write(Utils::replace($message, $context), 'ALERT');
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function critical($message, array $context = array())
    {
        $this->write(Utils::replace($message, $context), 'CRITICAL');
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function error($message, array $context = array())
    {
        $this->write(Utils::replace($message, $context), 'ERROR');
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function warning($message, array $context = array())
    {
        $this->write(Utils::replace($message, $context), 'WARNING');
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function notice($message, array $context = array())
    {
        $this->write(Utils::replace($message, $context), 'NOTICE');
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function info($message, array $context = array())
    {
        $this->write(Utils::replace($message, $context), 'INFO');
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function debug($message, array $context = array())
    {
        $this->write(Utils::replace($message, $context), 'DEBUG');
    }

    /**
     * @param mixed $level
     * @param string $message
     * @param array $context
     */
    public function log($level, $message, array $context = array())
    {
        $this->write(Utils::replace($message, $context), $level);
    }

    /**
     * Writes to log file
     *
     * @param string $content
     * @param string $level
     */
    private function write(string $content, string $level = 'LOG') {
        $content = sprintf("%-' 8s | %-' 10s | %s", date('H:m:s') ,$level, $content) . PHP_EOL;

        $file = fopen(__DIR__ . '/../../../storage/logs/' . date('Y-m-d') . '.log', 'a');
        fwrite($file, $content);
        fclose($file);
    }

}
