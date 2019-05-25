<?php

namespace RiotQuest\Components\Framework\Client;

use RiotQuest\Components\DataProviders\BaseProvider;
use RiotQuest\Components\DataProviders\DataDragon;
use RiotQuest\Components\DataProviders\Provider;
use RiotQuest\Components\Framework\Cache\AutoLimitModel;
use RiotQuest\Components\Framework\Cache\CacheModel;
use RiotQuest\Components\Framework\Cache\RequestModel;
use RiotQuest\Components\Framework\RateLimit\Manager;
use RiotQuest\Contracts\LeagueException;
use Symfony\Component\Dotenv\Dotenv;

class Application {

    /**
     * Special rules for endpoints
     *
     * @var array
     */
    public static $rules = [
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
     * @var array
     */
    protected static $caches = [];

    /**
     * @var array
     */
    protected static $limits = [];

    /**
     * @var string
     */
    protected static $provider = DataDragon::class;

    /** @var Manager */
    protected static $manager;

    /**
     * @var array
     */
    protected static $keys = [];

    /**
     * @var string
     */
    protected static $locale = "en_US";

    /**
     * @param mixed ...$keys
     */
    public static function initialize(...$keys) {
        static::$caches = [
            'generic' => new CacheModel(),
            'request' => new RequestModel(),
            'limits' => new AutoLimitModel()
        ];

        foreach ($keys as $key) {
            static::$keys[$key->getType()] = $key;
        }

        static::$manager = new Manager();

        call_user_func([BaseProvider::class, 'onEnable']);
        call_user_func([Provider::class, 'boot']);
    }

    /**
     * @throws LeagueException
     */
    public static function load() {
        if (file_exists(__DIR__ . '/../../../../../.env')) {
            (new Dotenv())->load(__DIR__ . '/../../../../../.env');
        }
        
        $keys = [];

        if (getenv('RIOTQUEST_STANDARD_KEY')) $keys[] = static::getKey('STANDARD');
        if (getenv('RIOTQUEST_TOURNAMENT_KEY')) $keys[] = static::getKey('TOURNAMENT');

        if (count($keys)) {
            return static::initialize(...$keys);
        }

        throw new LeagueException("No valid API keys were found.");
    }

    /**
     * @param string $region
     * @param string $endpoint
     * @param string $key
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function hittable(string $region, string $endpoint, string $key)
    {
        return static::getManager()->canRequest($region, $endpoint, strtolower($key)) && static::getManager()->canRequest($region, 'default', $key);
    }

    /**
     * @param string $region
     * @param string $endpoint
     * @param string $key
     * @param string $limits
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function register(string $region, string $endpoint, string $key, $limits = 'default') {
        static::getManager()->registerCall($region, $endpoint, $key, $limits);
        static::getManager()->registerCall($region, 'default', $key, static::$keys[strtoupper($key)]->getLimits());
    }

    /**
     * @param $target
     * @return Token
     */
    private static function getKey($target) {
        return new Token(getenv("RIOTQUEST_{$target}_KEY"), $target, getenv("RIOTQUEST_{$target}_LIMIT"));
    }

    /**
     * @return Manager
     */
    public static function getManager()
    {
        return self::$manager;
    }

    /**
     * @return mixed
     */
    public static function getLocale()
    {
        return self::$locale;
    }

    /**
     * @param mixed $locale
     */
    public static function setLocale($locale): void
    {
        self::$locale = $locale;
    }

    /**
     * @return string
     */
    public static function getProvider()
    {
        return self::$provider;
    }

    /**
     * @param string $provider
     */
    public static function setProvider(string $provider)
    {
        self::$provider = $provider;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws LeagueException
     */
    public static function getCache(string $key = 'generic') {
        if (static::$caches[$key]) {
            return static::$caches[$key];
        }

        throw new LeagueException("Cache Provider could not be located.");
    }

    /**
     * @return mixed
     */
    public static function getKeys() {
        return static::$keys;
    }

}
