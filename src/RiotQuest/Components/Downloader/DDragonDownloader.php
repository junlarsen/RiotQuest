<?php

namespace RiotQuest\Components\Downloader;

use League\Flysystem\Adapter\Local;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;
use RiotQuest\Components\Client\Application;
use RiotQuest\Components\Engine\Utils;
use RiotQuest\Components\Game\Game;
use RiotQuest\Contracts\LeagueException;

/**
 * Class DDragonDownloader
 * @package RiotQuest\Components\Downloader
 */
class DDragonDownloader
{

    /**
     * @var string
     */
    public static $baseurl = "https://ddragon.leagueoflegends.com/cdn/{version}";

    /**
     * Files to download
     *
     * @var array
     */
    private static $map = [
        'champion' => '/data/{locale}/champion.json',
        'item' => '/data/{locale}/item.json',
        'championFull' => '/data/{locale}/championFull.json',
        'runes' => '/data/{locale}/runesReforged.json',
        'summoner' => '/data/{locale}/summoner.json',
        'icon' => '/data/{locale}/profileicon.json',
        'map' => '/data/{locale}/map.json',
        'language' => '/data/{locale}/language.json',
    ];

    /**
     * @throws FileExistsException
     * @throws FileNotFoundException
     * @throws LeagueException
     */
    public static function download(): void
    {
        $fs = new Filesystem(new Local(__DIR__ . "/../../../storage/static"));

        $fs->deleteDir(Application::getInstance()->getLocale());
        $fs->createDir(Application::getInstance()->getLocale());

        foreach (static::$map as $key => $value) {
            $url = Utils::replace(static::$baseurl . $value, ['version' => Game::current(), 'locale' => Application::getInstance()->getLocale()]);

            $fs->write(Utils::replace("{locale}/{key}.json", ['locale' => Application::getInstance()->getLocale(), 'key' => $key]), file_get_contents($url));
        }
    }

}
