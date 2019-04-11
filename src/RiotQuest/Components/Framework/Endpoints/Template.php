<?php

namespace RiotQuest\Components\Framework\Endpoints;

/**
 * Class Template
 *
 * Parent of all Endpoints.
 *
 * @package RiotQuest\Components\Riot\Endpoints
 */
class Template
{

    /**
     * API Region to send request to
     *
     * @var string
     */
    protected $region;

    /**
     * Default time to live in CacheModel for item
     *
     * @var int $ttl = 3600
     */
    protected $ttl = 3600;

    /**
     * Parent for all Endpoints. Takes a region and a ttl to
     * initiate.
     *
     * @param $region
     * @param $ttl
     */
    public function __construct(string $region, int $ttl)
    {
        $this->region = $region;
        $this->ttl = $ttl;
    }

}
