<?php

namespace RiotQuest\Components\Framework\RateLimit;

use RiotQuest\Components\Framework\Client\Client;
use RiotQuest\Components\Framework\Engine\Filesystem;

class Manager
{

    private $limits = [];

    public function __construct()
    {
        $this->limits = [
            'standard' => [
                'default' => new Node(...Client::getLimits('STANDARD') ?: [0, 0])
            ],
            'tournament' => [
                'default' => new Node(...Client::getLimits('TOURNAMENT') ?: [0, 0])
            ]
        ];
        #$this->limits = json_decode(Filesystem::getCacheFile('ratelimit.json'), 1);
    }

    public function __destruct()
    {
        #Filesystem::putCacheFile('ratelimit.json', json_encode($this->limits));
    }

    public function registerCall($region, $endpoint = 'default', $key = 'standard', $limits = [20, 60])
    {
        #$this->limits[$key][$region][$endpoint] = new Node(...$limits);
    }

    public function getLimits()
    {
        return $this->limits;
    }

}
