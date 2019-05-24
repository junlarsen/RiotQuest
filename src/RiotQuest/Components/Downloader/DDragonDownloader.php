<?php

namespace RiotQuest\Components\Downloader;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use RiotQuest\Client;
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
        
        $fs->deleteDir(Client::getLocale());
        $fs->createDir(Client::getLocale());

        foreach (static::$map as $key => $value) {
            $url = Library::replace(static::$baseurl . $value, ['version' => Game::current(), 'locale' => Client::getLocale()]);
            
            $fs->write(Library::replace("{locale}/{key}.json", ['locale' => Client::getLocale(), 'key' => $key]), file_get_contents($url));
        }
    }

}
