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
use RiotQuest\Contracts\LeagueException;
use RiotQuest\Contracts\ParameterException;
use Symfony\Component\Dotenv\Dotenv;

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
     * Rules for caching and throwing errors.
     *
     * @var array
     */
    public static $config = [
        'HTTP_ERROR_EXCEPT' => [
            'code.id'
        ],
        'FORCE_CACHE_PERMANENT' => [
            'match.id', 'match.timeline'
        ],
        'FORCE_CACHE_NONE' => [
            'code.id'
        ]
    ];

    /**
     * CacheProvider for caching. Must be PSR-16 compliant
     *
     * @var array                                                                                                           *
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

    protected static $locale = "en_US";

    /**
     * Initialize the entire application, this way RiotQuest
     * doesn't interfere with your program until you actually
     * load being using it.
     *
     * @param Token ...$keys
     * @throws ParameterException
     */
    public static function initialize(...$keys)
    {
        static::$caches = [
            'generic' => new CacheModel(),
            'request' => new RequestModel(),
            'limits' => new AutoLimitModel()
        ];
        if (count($keys)) {
            foreach ($keys as $key) {
                if ($key instanceof Token) {
                    static::$keys[$key->getType()] = $key;
                } else {
                    throw new ParameterException("The API key must be an instance of the " . Token::class . " class. (" . gettype($key) . " passed.)");
                }
            }
            static::$manager = new Manager();
        } else {
            throw new ParameterException("You must provide at least one API key to this function.");
        }
    }

    /**
     * Set the locale (used for DDragon)
     *
     * @param string $locale
     */
    public static function setLocale(string $locale) {
        static::$locale = $locale;
    }

    /**
     * @return string
     */
    public static function getLocale()
    {
        return self::$locale;
    }

    /**
     * Bootstrap the framework
     *
     * @throws LeagueException
     * @throws ParameterException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     */
    public static function boot()
    {
        if (file_exists(__DIR__ . '/../../../../../.env')) {
            (new Dotenv())->load(__DIR__ . '/../../../../../.env');
        }
        static::loadFromEnvironment();
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
        } else {
            throw new ParameterException("No valid API keys could be located.");
        }
    }

    /**
     * Loads a keytype from environment
     *
     * @param $key
     * @return Token
     */
    public static function loadKeyFromEnv(string $key)
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
    public static function getLimits(string $key)
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
    public static function registerHit(string $region, string $endpoint, string $key, $limits = 'default')
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
    public static function isHittable(string $region, string $endpoint, string $key)
    {
        return static::getManager()->canRequest($region, $endpoint, strtolower($key)) && static::getManager()->canRequest($region, 'default', $key);
    }

    /**
     * Get cacheprovider
     *
     * @param string $key
     * @return CacheInterface
     * @throws LeagueException
     */
    public static function getCache(string $key = 'generic')
    {
        if (static::$caches[$key]) {
            return static::$caches[$key];
        } else {
            throw new LeagueException("Cache Provider could not be found.");
        }
    }

    /**
     * Get API keys
     *
     * @return array
     * @throws LeagueException
     */
    public static function getKeys()
    {
        if (count(static::$keys)) {
            return static::$keys;
        } else {
            throw new LeagueException("No API keys were found.");
        }
    }

    /**
     * Access Champion V3 endpoints
     *
     * @param $region
     * @param int $ttl
     * @return Champion
     */
    public static function champion(string $region, $ttl = 3600)
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
    public static function mastery(string $region, $ttl = 3600)
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
    public static function league(string $region, $ttl = 3600)
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
    public static function status(string $region, $ttl = 3600)
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
    public static function match(string $region, $ttl = 3600)
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
    public static function spectator(string $region, $ttl = 3600)
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
    public static function summoner(string $region, $ttl = 3600)
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
    public static function code(string $region, $ttl = 3600)
    {
        return new Code($region, $ttl);
    }

    /**
     * @return bool
     * @todo
     * @throws LeagueException
     */
    public static function stub()
    {
        throw new LeagueException("Unsupported Endpoint.");
    }

    /**
     * @return bool
     * @todo
     * @throws LeagueException
     */
    public static function tournament()
    {
        throw new LeagueException("Unsupported Endpoint.");
    }

}
