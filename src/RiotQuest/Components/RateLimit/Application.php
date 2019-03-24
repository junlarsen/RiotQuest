<?php

namespace RiotQuest\Components\RateLimit;

use Psr\SimpleCache\CacheInterface;
use RiotQuest\Components\Riot\Client\Client;
use RiotQuest\Contracts\RateLimit;

/**
 * Class Application
 *
 * Rate Limit handler for the X-Application-Limit headers
 * Throttles on last request before limit would be reached.
 *
 * @package RiotQuest\Components\RateLimit
 */
class Application implements RateLimit
{

    /**
     * The max limits for the given STANDARD | TOURNAMENT
     * API keys
     *
     * @var array
     */
    protected static $limits = [];


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
    public static function enable()
    {
        static::$limits['STANDARD'] = Client::getLimits('STANDARD') ?? [];
        static::$limits['TOURNAMENT'] = Client::getLimits('TOURNAMENT') ?? [];
        static::$cache = Client::getCache();
    }

    /**
     * Determine whether you're able to call given region or not
     * @param $region
     *
     * @param null $endpoint
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function available($region, $endpoint = null)
    {
        if (static::$cache->has('riotquest.limits.app')) {
            $items = json_decode(static::$cache->get('riotquest.limits.app'), 1);
            if (isset($items[$region]) && $items[$region]['count'] + 1 > $items[$region]['cap']) {
                return false;
            }
        }
        return true;
    }

    /**
     * Hit defined region for one request.
     *
     * @param string $region Targetted region
     * @param null $endpoint Interface requirement - null
     * @param string $scope  The scope to target, either STANDARD or TOURNAMENT
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function hit($region, $endpoint = null, $scope = 'STANDARD')
    {
        $time = time();
        if (!static::$cache->has('riotquest.limits.app')) {
            static::$cache->set('riotquest.limits.app', json_encode([
                $region => [
                    'cap' => (int)static::$limits[$scope]['count'],
                    'count' => 1,
                    'ttl' => $time + (int)static::$limits[$scope]['interval']
                ]
            ]), (int)static::$limits[$scope]['interval']);
        } else {
            $current = json_decode(static::$cache->get('riotquest.limits.app'), 1);
            if (isset($current[$region]['ttl'])) {
                $current[$region] = [
                    'cap' => (int)static::$limits[$scope]['count'],
                    'count' => $current[$region]['count'] + 1,
                    'ttl' => $current[$region]['ttl']
                ];
                static::$cache->set('riotquest.limits.app', json_encode($current), ($current[$region]['ttl'] - $time));
            }
        }
    }

}
