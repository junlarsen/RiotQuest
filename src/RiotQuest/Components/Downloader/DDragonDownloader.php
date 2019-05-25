<?php

namespace RiotQuest\Components\Downloader;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use RiotQuest\Components\Framework\Client\Application;
use RiotQuest\Components\Framework\Engine\Library;
use RiotQuest\Components\Game\Game;

class DDragonDownloader {

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
     * @throws \League\Flysystem\FileExistsException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \RiotQuest\Contracts\LeagueException
     */
    public static function download() {
        $fs = new Filesystem(new Local(__DIR__ . "/../../../storage/static"));
        
        $fs->deleteDir(Application::getLocale());
        $fs->createDir(Application::getLocale());

        foreach (static::$map as $key => $value) {
            $url = Library::replace(static::$baseurl . $value, ['version' => Game::current(), 'locale' => Application::getLocale()]);
            
            $fs->write(Library::replace("{locale}/{key}.json", ['locale' => Application::getLocale(), 'key' => $key]), file_get_contents($url));
        }
    }

}
