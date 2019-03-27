<?php

namespace RiotQuest\Components\Framework\Collections;

use RiotQuest\Components\Framework\Utils\Versions;

/**
 * Class Summoner
 *
 * @see https://developer.riotgames.com/api-methods/#summoner-v4/GET_getBySummonerName
 *
 * @property string $id
 * @property string $accountId
 * @property string $puuid
 * @property string $name
 * @property int $profileIconId
 * @property double $revisionDate
 * @property int $summonerLevel
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class Summoner extends Collection
{

    /**
     * Get the current summoner icon link
     *
     * @param string $provider
     * @return string
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getIconLink($provider = 'ddragon'): string 
    {
        switch ($provider) {
            case 'ddragon':
                return sprintf('https://ddragon.leagueoflegends.com/cdn/%s/img/profileicon/%d.png', Versions::current(), $this['profileIconId']);
            case 'sdragon':
                return sprintf('https://static.supergrecko.com/superdragon/icon/%d.png', $this['profileIconId']);
        }
    }

}
