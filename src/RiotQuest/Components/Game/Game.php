<?php

namespace RiotQuest\Components\Game;

use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use RiotQuest\Components\Framework\Client\Application;
use RiotQuest\Contracts\LeagueException;

class Game
{

    /**
     * Current Game version
     *
     * @var string
     */
    private static $current;

    /**
     * Get latest Game Version and caches for 2 hours
     *
     * @return string
     * @throws LeagueException
     * @throws FileExistsException
     * @throws FileNotFoundException
     */
    public static function current(): string
    {
        if (!static::$current) {
            if (!Application::getInstance()->getCache()->has('riotquest.framework.version')) {
                $versions = json_decode(file_get_contents('https://ddragon.leagueoflegends.com/api/versions.json'), 1);
                Application::getInstance()->getCache()->set('riotquest.framework.version', json_encode([
                    'latest' => $versions[0],
                    'all' => $versions
                ]), 7200);
            }
            static::$current = json_decode(Application::getInstance()->getCache()->get('riotquest.framework.version'), 1)['latest'];
        }
        return static::$current;
    }

}
