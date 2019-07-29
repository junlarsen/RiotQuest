<?php

namespace RiotQuest\Components\Game;

use RiotQuest\Components\Client\Application;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * Class Game
 * @package RiotQuest\Components\Game
 */
class Game
{

    /**
     * Current Game version
     *
     * @var array
     */
    private static $current;

    /**
     * Get the latest game version and cache for 6h
     *
     * @return mixed
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public static function current()
    {
        static::$current = Application::getInstance()->getCache()->get('riotquest.internal.gameversion', function(ItemInterface $item) {
            $item->expiresAfter(3600 * 6); // 6 Hours

            $data = json_decode(file_get_contents('https://ddragon.leagueoflegends.com/api/versions.json'));

            return [
                'latest' => $data[0],
                'all' => $data
            ];
        });

        return static::$current['latest'];
    }

}
