<?php

namespace RiotQuest\Components\DataProviders;

use RiotQuest\Components\Downloader\DDragonDownloader;
use RiotQuest\Components\Framework\Client\Application;
use RiotQuest\Components\Framework\Engine\Library;
use RiotQuest\Components\Game\Game;

class BaseProvider {

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
     * @internal Boot to set version
     * 
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \RiotQuest\Contracts\LeagueException
     */
    public static function onEnable() {
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
    public static function override(string $version) {
        static::$version = $version;
    }

    /**
     * @param string $file
     * @return mixed
     */
    public static function get(string $file) {
        if (!file_exists(__DIR__ . "/../../../storage/static/" . Application::getLocale() . "/champion.json")) {
            DDragonDownloader::download();
        }

        if (!isset(static::$load[$file])) {
            $data = json_decode(file_get_contents(Library::replace(__DIR__ . "/../../../storage/static/{locale}/{file}.json", ['locale' => Application::getLocale(), 'file' => $file])), 1);

            static::$load[$file] = $data;
        }

        return static::$load[$file];
    }

}
