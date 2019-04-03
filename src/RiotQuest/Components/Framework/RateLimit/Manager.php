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
        if (is_string($limits[1])) $limits[1] = explode(',', $limits[1])[0];
        $this->cache->set($ref, json_encode([
            'max' => $now['max'] ?? $limits[0],
            'count' => (isset($now['count']) ? ($now['count'] + 1) : 0),
            'ttl' => $now['ttl'] ?? (float)time() + $limits[1]
        ]), $now['ttl'] ? $now['ttl'] - time() : $limits[1]);
    }

    /**
     * Decide whether you can hit an endpoint with region, key and endpoint or not.
     *
     * @param $region
     * @param string $endpoint
     * @param string $key
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function canRequest($region, $endpoint = 'default', $key = 'standard')
    {
        $ref = implode('.', [$key, $region, $endpoint]);
        if ($this->cache->has($ref)) {
            $limits = json_decode($this->cache->get($ref), 1);
            return $limits['count'] + 1 < $limits['max'];
        }
        return true;
    }

}

