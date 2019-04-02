<?php

namespace RiotQuest\Components\Framework\RateLimit;

use Psr\SimpleCache\CacheInterface;
use RiotQuest\Components\Framework\Client\Client;

class Manager
{

    private $limits = [];

    /**
     * Cache namespace for requests
     *
     * @var CacheInterface
     */
    private $cache;

    /**
     * Manager constructor.
     */
    public function __construct()
    {
        $this->cache = Client::getCache('limits');
    }

    /**
     * Registers an API call to the cache
     *
     * @param $region
     * @param string $endpoint
     * @param string $key
     * @param array $limits
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function registerCall($region, $endpoint = 'default', $key = 'standard', $limits = [1, 5])
    {
        $ref = implode('.', [$key, $region, $endpoint]);
        $now = json_decode($this->cache->get($ref), 1);

        $this->cache->set($ref, json_encode([
            'max' => $now['max'] ?? $limits[0],
            'count' => (isset($now['count']) ? ($now['count'] + 1) : 0),
            'ttl' => $now['ttl'] ?? (float)time() + $limits[1]
        ]), $now['ttl'] ? $now['ttl'] - time() : $limits[1]);
    }

}

