<?php

namespace RiotQuest\Components\DataProviders;

use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use Psr\SimpleCache\InvalidArgumentException;
use RiotQuest\Components\Downloader\DDragonDownloader;
use RiotQuest\Components\Framework\Client\Application;
use RiotQuest\Components\Framework\Engine\Utils;
use RiotQuest\Components\Game\Game;
use RiotQuest\Contracts\LeagueException;

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
     * @throws FileNotFoundException
     * @throws InvalidArgumentException
     * @throws LeagueException
     * @internal Boot to set version
     *
     */
    public static function onEnable(): void
    {
        static::$version = Game::current();
        $manifest = json_decode(file_get_contents(__DIR__ . "/../../../storage/static/manifest.json"), 1);

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
     * @throws LeagueException
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
