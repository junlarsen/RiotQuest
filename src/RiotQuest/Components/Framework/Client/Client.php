<?php

namespace RiotQuest\Components\Framework\Client;

use RiotQuest\Components\Framework\Cache\AutoLimitModel;
use RiotQuest\Components\Framework\Cache\CacheModel;
use RiotQuest\Components\Framework\Cache\RequestModel;
use RiotQuest\Components\Framework\RateLimit\Manager;
use RiotQuest\Components\Framework\Endpoints\Champion;
use RiotQuest\Components\Framework\Endpoints\Code;
use RiotQuest\Components\Framework\Endpoints\League;
use RiotQuest\Components\Framework\Endpoints\Mastery;
use RiotQuest\Components\Framework\Endpoints\Match;
use RiotQuest\Components\Framework\Endpoints\Spectator;
use RiotQuest\Components\Framework\Endpoints\Status;
use RiotQuest\Components\Framework\Endpoints\Summoner;
use Psr\SimpleCache\CacheInterface;

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
     * @var array
     */
    protected static $caches = [];

    /**
     * Set rate limits for the given TOURNAMENT and STANDARD
     * keys
     *
     * @var array
     */
    protected static $limits;

    /**
     * Rate Limit handler
     *
     * @var Manager
     */
    protected static $manager;

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
     * @param mixed ...$keys
     */
    public static function initialize(...$keys)
    {
        static::$caches = [
            'generic' => new CacheModel(),
            'request' => new RequestModel(),
            'limits' => new AutoLimitModel()
        ];
        foreach ($keys as $key) {
            static::$keys[$key->getType()] = $key;
        }
        static::$manager = new Manager();
    }

    /**
     * Loads the client from the environment variables
     */
    public static function loadFromEnvironment()
    {
        $discoveredKeys = [];
        if (getenv('RIOTQUEST_STANDARD_KEY')) $discoveredKeys[] = Client::loadKeyFromEnv('STANDARD');
        if (getenv('RIOTQUEST_TOURNAMENT_KEY')) $discoveredKeys[] = Client::loadKeyFromEnv('TOURNAMENT');
        if ($discoveredKeys) {
            Client::initialize(...$discoveredKeys);
        }
    }

    /**
     * Loads a keytype from environment
     *
     * @param $key
     * @return Token
     */
    public static function loadKeyFromEnv($key)
    {
        return new Token(getenv("RIOTQUEST_{$key}_KEY"), $key, getenv("RIOTQUEST_{$key}_LIMIT"));
    }

    /**
     * @return Manager
     */
    public static function getManager()
    {
        return self::$manager;
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
     * Hit an API region and endpoint
     *
     * @param $region
     * @param $endpoint
     * @param $key
     * @param $limits
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function registerHit($region, $endpoint, $key, $limits = 'default')
    {
        static::getManager()->registerCall($region, $endpoint, $key, $limits);
        static::getManager()->registerCall($region, 'default', $key, static::$keys[strtoupper($key)]->getLimits());
    }

    /**
     * Determine whether an API region and endpoint can be hit or not
     *
     * @param $region
     * @param $endpoint
     * @param $key
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function isHittable($region, $endpoint, $key)
    {
        return static::getManager()->canRequest($region, $endpoint, strtolower($key)) && static::getManager()->canRequest($region, 'default', $key);
    }

    /**
     * Get cacheprovider
     *
     * @param string $key
     * @return CacheInterface
     */
    public static function getCache($key = 'generic')
    {
        return static::$caches[$key];
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

    /**
     * Access Champion V3 endpoints
     *
     * @param $region
     * @param int $ttl
     * @return Champion
     */
    public static function champion($region, $ttl = 3600)
    {
        return new Champion($region, $ttl);
    }

    /**
     * Access Champion Mastery V4 endpoints
     *
     * @param $region
     * @param int $ttl
     * @return Mastery
     */
    public static function mastery($region, $ttl = 3600)
    {
        return new Mastery($region, $ttl);
    }

    /**
     * Access League V4 endpoints
     *
     * @param $region
     * @param int $ttl
     * @return League
     */
    public static function league($region, $ttl = 3600)
    {
        return new League($region, $ttl);
    }

    /**
     * Access LOL Status V3 endpoints
     *
     * @param $region
     * @param int $ttl
     * @return Status
     */
    public static function status($region, $ttl = 3600)
    {
        return new Status($region, $ttl);
    }

    /**
     * Access Match V4 endpoints
     *
     * @param $region
     * @param int $ttl
     * @return Match
     */
    public static function match($region, $ttl = 3600)
    {
        return new Match($region, $ttl);
    }

    /**
     * Access Spectator V4 endpoints
     *
     * @param $region
     * @param int $ttl
     * @return Spectator
     */
    public static function spectator($region, $ttl = 3600)
    {
        return new Spectator($region, $ttl);
    }

    /**
     * Access Summoner V4 endpoints
     *
     * @param $region
     * @param int $ttl
     * @return Summoner
     */
    public static function summoner($region, $ttl = 3600)
    {
        return new Summoner($region, $ttl);
    }

    /**
     * Access Third Party Code V4 endpoint
     *
     * @param $region
     * @param int $ttl
     * @return Code
     */
    public static function code($region, $ttl = 3600)
    {
        return new Code($region, $ttl);
    }

    /**
     * @return bool
     * @todo
     */
    public static function stub()
    {
        return false;
    }

    /**
     * @return bool
     * @todo
     */
    public static function tournament()
    {
        return false;
    }

}
