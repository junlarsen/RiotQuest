<?php

namespace RiotQuest\Components\Client;

use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use Psr\SimpleCache\InvalidArgumentException;
use RiotQuest\Components\DataProviders\BaseProvider;
use RiotQuest\Components\DataProviders\DataDragon;
use RiotQuest\Components\DataProviders\Provider;
use RiotQuest\Components\Logger\Logger;
use RiotQuest\Components\RateLimit\RateLimiter;
use RiotQuest\Contracts\LeagueException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Dotenv\Dotenv;

/**
 * @internal Internal Core API
 * Class Application
 *
 * @package RiotQuest\Components\Framework\Client
 */
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
        'CACHE_PERMANENT' => [
            'match.id', 'match.timeline'
        ],
        'CACHE_NONE' => [
            'code.id'
        ]
    ];

    /**
     * @var FilesystemAdapter
     */
    protected $adapter;

    /**
     * @var array
     */
    protected $limits = [];

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var string
     */
    protected $provider = DataDragon::class;

    /**
     * @var RateLimiter
     */
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
    protected static $app;

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
        $this->adapter = new FilesystemAdapter();
        $this->logger = new Logger();
        $this->manager = new RateLimiter();

        call_user_func([BaseProvider::class, 'onEnable']);
        call_user_func([Provider::class, 'boot']);

        if (file_exists(__DIR__ . '/../../../../.env')) {
            (new Dotenv())->load(__DIR__ . '/../../../../.env');
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

        throw new LeagueException("ERROR (code 12): No valid API keys were found.");
    }

    /**
     * @param string $region
     * @param string $endpoint
     * @param string $key
     * @return bool
     * @throws InvalidArgumentException
     * @throws FileNotFoundException
     * @throws LeagueException
     * @throws LeagueException
     */
    public function hittable(string $region, string $endpoint, string $key): bool
    {
        return $this->getManager()->requestable($region, $endpoint, $key) && $this->getManager()->requestable($region, 'default', $key);
    }

    /**
     * @param string $region
     * @param string $endpoint
     * @param string $key
     * @param $limits
     * @throws InvalidArgumentException
     * @throws FileExistsException
     * @throws FileNotFoundException
     * @throws LeagueException
     * @throws LeagueException
     */
    public function register(string $region, string $endpoint, string $key, $limits): void
    {
        $this->getManager()->register($region, $endpoint, $key, $limits);
        $this->getManager()->register($region, 'default', $key, $this->keys[strtoupper($key)]->getLimits());
    }

    /**
     * @param $level
     * @param $message
     * @param array $context
     */
    public static function log($level, $message, $context = []): void
    {
        self::getInstance()->getLogger()->log($level, $message, $context);
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
     * @return Logger
     */
    public function getLogger(): Logger
    {
        return $this->logger;
    }

    /**
     * @return RateLimiter
     */
    public function getManager(): RateLimiter
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
     * @return FilesystemAdapter
     */
    public function getCache(): FilesystemAdapter
    {
        return $this->adapter;
    }

    /**
     * @return Token[]
     */
    public function getKeys(): array
    {
        return $this->keys;
    }

}
