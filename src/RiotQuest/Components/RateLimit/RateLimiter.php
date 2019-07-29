<?php

namespace RiotQuest\Components\RateLimit;

use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use RiotQuest\Components\Client\Application;
use RiotQuest\Contracts\LeagueException;

/**
 * Class RateLimiter
 * @package RiotQuest\Components\Framework\RateLimit
 */
class RateLimiter
{

    /**
     * Cache namespace for requests
     *
     * @var CacheInterface
     */
    private $cache;

    /**
     * RateLimiter constructor.
     * @throws LeagueException
     */
    public function __construct()
    {
        $this->cache = Application::getInstance()->getCache();
    }

    public function register(string $region, string $target, string $key, array $limits) {
        $key = implode('.', ['riotquest', 'request', $key, $region, $target]);
    }

    public function registerCall(string $region, string $endpoint = 'default', string $key = 'standard', array $limits = [1, 5])
    {
        $ref = implode('.', [$key, $region, $endpoint]);
        $now = json_decode($this->cache->get($ref), 1);

        if (is_string($limits[1])) {
            $limits[1] = explode(',', $limits[1])[0];
        }

        $this->cache->set($ref, json_encode([
            'max' => (int)($now['max'] ?? $limits[0]),
            'count' => (isset($now['count']) ? ($now['count'] + 1) : 0),
            'ttl' => $now['ttl'] ?? (float)time() + $limits[1]
        ]), $now['ttl'] ? $now['ttl'] - time() : $limits[1]);

    }

    /**
     * Decide whether you can hit an endpoint with region, key and endpoint or not.
     *
     * @param string $region
     * @param string $endpoint
     * @param string $key
     * @return bool
     * @throws FileNotFoundException
     * @throws InvalidArgumentException
     * @throws LeagueException
     * @throws LeagueException
     */
    public function canRequest(string $region, string $endpoint = 'default', string $key = 'standard')
    {

        $ref = implode('.', [$key, $region, $endpoint]);

        if ($this->cache->has($ref)) {
            $limits = json_decode($this->cache->get($ref), 1);

            return ($limits['count'] + 1) < $limits['max'];
        }

        return true;
    }

}

