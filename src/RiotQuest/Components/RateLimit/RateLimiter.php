<?php

namespace RiotQuest\Components\RateLimit;

use Carbon\Carbon;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/**
 * Class RateLimiter
 *
 * @package RiotQuest\Components\Framework\RateLimit
 */
class RateLimiter
{

    /**
     * Cache namespace for requests
     *
     * @var FilesystemAdapter
     */
    private $cache;

    /**
     * RateLimiter constructor.
     */
    public function __construct()
    {
        $this->cache = new FilesystemAdapter();
    }

    /**
     * Register a call to the API
     *
     * @param string $region
     * @param string $target
     * @param string $key
     * @param array $limits
     */
    public function register(string $region, string $target, string $key, array $limits): void {
        $key = implode('.', ['riotquest', 'request', $key, $region, $target]);
        $item = $this->cache->getItem($key);

        // If item is empty
        if (!$item->isHit()) {
            $item->expiresAfter((int) $limits[1]);
            $item->set([
                'max' => (int) $limits[0],
                'count' => 1,
                'expires' => (float) time() + (int) $limits[1]
            ]);
        } else {
            $state = $item->get();
            $item->set([
                'max' => $state['max'],
                'count' => $state['count'] + 1,
                'expires' => $state['expires']
            ]);
            // fuck you symfony cache expiration
            $item->expiresAt(Carbon::createFromTimestamp($state['expires']));
        }

        $this->cache->save($item);
    }

    /**
     * Determine whether we're able to request to the API at a given endpoint, or string default for app
     *
     * @param string $region
     * @param string $target
     * @param string $key
     * @return bool
     */
    public function requestable(string $region, string $target, string $key): bool {
        $key = implode('.', ['riotquest', 'request', $key, $region, $target]);

        $item = $this->cache->getItem($key);

        // If this is not in cache
        if (!$item->isHit()) {
            return true;
        } else {
            $state = $item->get();
            return ($state['count'] + 1) <= $state['max'];
        }
    }

}

