<?php

namespace RiotQuest\Components\Riot\Client;

use RiotQuest\Components\RateLimit\Application;
use RiotQuest\Components\RateLimit\Endpoint;
use RiotQuest\Components\Riot\Endpoints\League;
use RiotQuest\Components\Riot\Endpoints\Summoner;
use Psr\SimpleCache\CacheInterface;
use Closure;

/**
 * Class Client
 *
 * The entire RiotQuest Framework is bundled into
 * this static class.
 *
 * @package RiotQuest\Components\Riot\Client
 */
class Client
{

    /**
     * CacheProvider for caching. Must be PSR-16 compliant
     *
     * @var CacheInterface
     */
    protected static $cache;

    /**
     * Set rate limits for the given TOURNAMENT and STANDARD
     * keys
     *
     * @var array
     */
    protected static $limits;

    /**
     * List of set event listeners
     *
     * @var array
     */
    protected static $listeners = [];

    /**
     * The API keys
     *
     * @var array
     */
    protected static $keys = [
        'STANDARD' => null,
        'TOURNAMENT' => null
    ];

    /**
     * Initialize the entire application, this way RiotQuest
     * doesn't interfere with your program until you actually
     * load being using it.
     *
     * @param CacheInterface $cache
     * @param mixed ...$keys
     */
    public static function initialize(CacheInterface $cache, ...$keys)
    {
        static::$cache = $cache;
        foreach ($keys as $key) {
            static::$keys[$key->getType()] = $key;
        }
        Application::enable();
        Endpoint::enable();
    }

    /**
     * Get the set rate limits
     *
     * @param $key
     * @return array
     */
    public static function getLimits($key)
    {
        return static::$keys[$key] ? static::$keys[$key]->getLimits() : [];
    }

    /**
     * Add an event listener for given event
     *
     * @param $event
     * @param Closure $closure
     */
    public static function on($event, Closure $closure)
    {
        static::$listeners[$event][] = $closure;
    }

    /**
     * Dispatch event listeners for given event with args
     *
     * @param $event
     * @param mixed ...$args
     */
    public static function emit($event, ...$args)
    {
        foreach (static::$listeners[$event] as $listener) {
            call_user_func_array([$listener, 'call'], array_merge([new static], $args));
        }
    }

    /**
     * Hit an API region and endpoint
     *
     * @param $region
     * @param $endpoint
     * @param $lim
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function hit($region, $endpoint, $lim)
    {
        Application::hit($region);
        Endpoint::hit($region, $endpoint, null, $lim);
    }

    /**
     * Determine whether an API region and endpoint can be hit or not
     *
     * @param $region
     * @param $endpoint
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function available($region, $endpoint)
    {
        return Endpoint::available($region, $endpoint) && Application::available($region);
    }

    /**
     * Get cacheprovider
     *
     * @return CacheInterface
     */
    public static function getCache()
    {
        return static::$cache;
    }

    /**
     * Get API keys
     *
     * @return array
     */
    public static function getKeys()
    {
        return static::$keys;
    }

    public static function mastery()
    {

    }

    public static function league($region, $ttl = 3600)
    {
        return new League($region, $ttl);
    }

    public static function status()
    {

    }

    public static function match()
    {

    }

    public static function spectator()
    {

    }

    public static function summoner($region, $ttl = 3600)
    {
        return new Summoner($region, $ttl);
    }

    public static function code()
    {

    }

    public static function stub()
    {

    }

    public static function tournament()
    {

    }

}
