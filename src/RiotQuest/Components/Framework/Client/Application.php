<?php

namespace RiotQuest\Components\Framework\Client;

use RiotQuest\Components\DataProviders\BaseProvider;
use RiotQuest\Components\DataProviders\DataDragon;
use RiotQuest\Components\DataProviders\Provider;
use RiotQuest\Components\Framework\Cache\RateLimitCache;
use RiotQuest\Components\Framework\Cache\Cache;
use RiotQuest\Components\Framework\Cache\RequestCache;
use RiotQuest\Components\Framework\RateLimit\Manager;
use RiotQuest\Contracts\LeagueException;
use Symfony\Component\Dotenv\Dotenv;

class Application
{

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
    protected $caches = [];

    /**
     * @var array
     */
    protected $limits = [];

    /**
     * @var string
     */
    protected $provider = DataDragon::class;

    /** @var Manager */
    protected $manager;

    /**
     * @var array
     */
    protected $keys = [];

    /**
     * @var string
     */
    protected $locale = "en_US";

    /**
     * Application Singleton
     *
     * @var Application
     */
    public static $app;

    /**
     * Application singleton function
     * 
     * @return Application
     */
    public static function getInstance(): Application
    {
        static::$app = static::$app ?? new Application();
        return static::$app;
    }

    /**
     * @param Token[] ...$keys
     */
    public function addKeys(...$keys): void
    {
        foreach ($keys as $key) {
            $this->keys[$key->getType()] = $key;
        }
    }

    /**
     * Bootstrap the application
     *
     * @throws LeagueException
     */
    public function load(): void
    {
        $this->caches = [
            'generic' => new Cache(),
            'request' => new RequestCache(),
            'limits' => new RateLimitCache()
        ];

        call_user_func([BaseProvider::class, 'onEnable']);
        call_user_func([Provider::class, 'boot']);
        $this->manager = new Manager();

        if (file_exists(__DIR__ . '/../../../../../.env')) {
            (new Dotenv())->load(__DIR__ . '/../../../../../.env');
        }

        $keys = [];

        if ($_ENV['RIOTQUEST_STANDARD_KEY']) {
            $keys[] = $this->getKey('STANDARD');
        }

        if ($_ENV['RIOTQUEST_TOURNAMENT_KEY']) {
            $keys[] = $this->getKey('TOURNAMENT');
        }

        if (count($keys)) {
            $this->addKeys(...$keys);
            return;
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
    public function hittable(string $region, string $endpoint, string $key): bool
    {
        return $this->getManager()->canRequest($region, $endpoint, strtolower($key)) && $this->getManager()->canRequest($region, 'default', $key);
    }

    /**
     * @param string $region
     * @param string $endpoint
     * @param string $key
     * @param string $limits
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function register(string $region, string $endpoint, string $key, $limits = 'default'): void
    {
        $this->getManager()->registerCall($region, $endpoint, $key, $limits);
        $this->getManager()->registerCall($region, 'default', $key, $this->keys[strtoupper($key)]->getLimits());
    }

    /**
     * @param $target
     * @return Token
     */
    private function getKey($target): Token
    {
        return new Token($_ENV["RIOTQUEST_{$target}_KEY"], $target, $_ENV["RIOTQUEST_{$target}_LIMIT"]);
    }

    /**
     * @return Manager
     */
    public function getManager(): Manager
    {
        return $this->manager;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     */
    public function setLocale($locale): void
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getProvider(): string 
    {
        return $this->provider;
    }

    /**
     * @param string $provider
     */
    public function setProvider(string $provider): void 
    {
        $this->provider = $provider;
    }

    /**
     * @param string $key
     * @return Cache
     * @throws LeagueException
     */
    public function getCache(string $key = 'generic'): Cache
    {
        if ($this->caches[$key]) {
            return $this->caches[$key];
        }

        throw new LeagueException("Cache Provider could not be located.");
    }

    /**
     * @return Token[]
     */
    public function getKeys(): array 
    {
        return $this->keys;
    }

}
