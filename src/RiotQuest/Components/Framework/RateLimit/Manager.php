<?php

namespace RiotQuest\Components\Framework\RateLimit;

use RiotQuest\Components\Framework\Client\Client;
use RiotQuest\Components\Framework\Engine\Filesystem;

class Manager
{

    private $limits = [];

    public function __construct()
    {

    }

    public function __destruct()
    {

    }

    public function registerCall($region, $endpoint = 'default', $key = 'standard', $limits = [20, 60])
    {

    }

    public function getLimits()
    {
        return $this->limits;
    }

}

