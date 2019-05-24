<?php

namespace RiotQuest\Components\Game;

use RiotQuest\Components\Framework\Client\Client;
use RiotQuest\Contracts\LeagueException;

class Game {

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
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws LeagueException
     */
    public static function current()
    {
        if (!static::$current) {
            if (!Client::getCache()->has('riotquest.framework.version')) {
                $versions = json_decode(file_get_contents('https://ddragon.leagueoflegends.com/api/versions.json'), 1);
                Client::getCache()->set('riotquest.framework.version', json_encode([
                    'latest' => $versions[0],
                    'all' => $versions
                ]), 7200);
            }
            static::$current = json_decode(Client::getCache()->get('riotquest.framework.version'), 1)['latest'];
        }
        return static::$current;
    }

}