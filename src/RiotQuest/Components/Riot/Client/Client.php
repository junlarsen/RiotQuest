<?php

namespace RiotQuest\Components\Riot\Client;

use RiotQuest\Components\RateLimit\Application;
use RiotQuest\Components\RateLimit\Endpoint;
use RiotQuest\Components\Riot\Endpoints\League;
use RiotQuest\Components\Riot\Endpoints\Summoner;

use Closure;
use Psr\SimpleCache\CacheInterface;

class Client
{

    protected static $cache;

    protected static $limits;

    protected static $listeners = [];

    protected static $keys = [
        'STANDARD' => null,
        'TOURNAMENT' => null
    ];

    public static function initialize(CacheInterface $cache, ...$keys)
    {
        static::$cache = $cache;
        foreach ($keys as $key) {
            static::$keys[$key->getType()] = $key;
        }
        Application::enable();
        Endpoint::enable();
    }

    public static function enable()
    {

    }

    public static function getLimits($key)
    {
        return static::$keys[$key] ? static::$keys[$key]->getLimits() : [];
    }

    public static function on($event, Closure $closure)
    {
        static::$listeners[$event][] = $closure;
    }

    public static function emit($event, ...$args)
    {
        foreach (static::$listeners[$event] as $listener) {
            call_user_func_array([$listener, 'call'], array_merge([new static], $args));
        }
    }

    public static function hit($region, $endpoint, $lim)
    {
        Application::hit($region);
        Endpoint::hit($region, $endpoint, null, $lim);
    }

    public static function available($region, $endpoint)
    {
        return Endpoint::available($region, $endpoint) && Application::available($region);
    }

    public static function getCache()
    {
        return static::$cache;
    }

    public static function getKeys()
    {
        return static::$keys;
    }

    public static function mastery()
    {

    }

    public static function league($region)
    {
        return new League($region);
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

    public static function summoner($region)
    {
        return new Summoner($region);
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
