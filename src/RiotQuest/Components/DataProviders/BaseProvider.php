<?php

namespace RiotQuest\Components\DataProviders;

use League\Flysystem\FileExistsException;
use Psr\Cache\InvalidArgumentException;
use RiotQuest\Components\Downloader\DDragonDownloader;
use RiotQuest\Components\Client\Application;
use RiotQuest\Components\Engine\Utils;
use RiotQuest\Components\Game\Game;

/**
 * Class BaseProvider
 *
 * @package RiotQuest\Components\DataProviders
 */
class BaseProvider
{

    /**
     * The version to pull data from
     *
     * @var string
     */
    protected static $version;

    /**
     * Files loaded into memory
     *
     * @var array
     */
    protected static $load = [];

    /**
     * @throws FileExistsException
     * @throws InvalidArgumentException
     * @internal Boot to set version
     */
    public static function onEnable(): void
    {
        static::$version = Game::current();
        $path = __DIR__ . "/../../../storage/static/manifest.json";

        if (!file_exists($path)) {
            file_put_contents($path, json_encode(['version' => static::$version]));
        }

        $manifest = json_decode(file_get_contents($path), 1);

        if ($manifest['version'] !== static::$version) {
            DDragonDownloader::download();
            $manifest['version'] = Game::current();

            file_put_contents(__DIR__ . "/../../../storage/static/manifest.json", json_encode($manifest));
        }
    }

    /**
     * Override the version with a custom one.
     *
     * @param string $version
     */
    public static function override(string $version): void
    {
        static::$version = $version;
    }

    /**
     * @param string $file
     * @return array
     * @throws FileExistsException
     * @throws InvalidArgumentException
     */
    public static function get(string $file): array
    {
        if (!file_exists(__DIR__ . "/../../../storage/static/" . Application::getInstance()->getLocale() . "/champion.json")) {
            DDragonDownloader::download();
        }

        if (!isset(static::$load[$file])) {
            $data = json_decode(file_get_contents(Utils::replace(__DIR__ . "/../../../storage/static/{locale}/{file}.json", ['locale' => Application::getInstance()->getLocale(), 'file' => $file])), 1);

            static::$load[$file] = $data;
        }

        return static::$load[$file];
    }

}
