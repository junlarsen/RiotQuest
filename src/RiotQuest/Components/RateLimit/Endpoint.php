<?php

namespace RiotQuest\Components\RateLimit;

use RiotQuest\Components\Framework\Client\Client;
use RiotQuest\Contracts\RateLimit;
use Psr\SimpleCache\CacheInterface;

/**
 * Class Endpoint
 *
 * Rate Limit handler for the X-Method-Rate-Limit headers
 *
 * @package RiotQuest\Components\RateLimit
 */
class Endpoint implements RateLimit
{

    /**
     * PSR-16 Compliant CacheProvider for storing
     * current rate limits.
     *
     * @var CacheInterface
     */
    protected static $cache;

    /**
     * Boot up function to set static props
     */
    public static function enable(): void
    {
        static::$cache = Client::getCache();
    }

    /**
     * Determine whether you can hit defined region and endpoint.
     *
     * @param $region
     * @param null $endpoint
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function available($region, $endpoint = null): bool
    {
        if (static::$cache->has('riotquest.limits.ends')) {
            $items = json_decode(static::$cache->get('riotquest.limits.ends'), 1);
            if (isset($items[$region][$endpoint]) && $items[$region][$endpoint]['count'] + 1 > $items[$region][$endpoint]['cap']) {
                return false;
            }
        }
        return true;
    }

    /**
     * Hit defined region and endpoint for one request
     *
     * @param $region
     * @param null $endpoint
     * @param string $scope
     * @param array $lim
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function hit($region, $endpoint = null, $scope = 'STANDARD', $lim = ['interval' => 60, 'count' => 20]): void
    {
        $time = time();
        if (!static::$cache->has('riotquest.limits.ends')) {
            static::$cache->set('riotquest.limits.ends', json_encode([
                $region => [
                    $endpoint => [
                        'cap' => $lim['count'],
                        'count' => 1,
                        'ttl' => (int) $time + $lim['interval']
                    ]
                ]
            ]), (int) $lim['interval']);
        } else {
            $current = json_decode(static::$cache->get('riotquest.limits.ends'), 1);
            if (isset($current[$region][$endpoint])) {
                $current[$region][$endpoint] = [
                    'cap' => $lim['count'],
                    'count' => $current[$region][$endpoint]['count'] + 1,
                    'ttl' => (int) $current[$region][$endpoint]['ttl']
                ];
                static::$cache->set('riotquest.limits.ends', json_encode($current), (int) $current[$region][$endpoint]['ttl'] - $time);
            }
        }
    }

}
