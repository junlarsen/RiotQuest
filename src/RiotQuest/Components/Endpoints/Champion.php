<?php

namespace RiotQuest\Components\Endpoints;

use Psr\Cache\InvalidArgumentException;
use RiotQuest\Components\Collections\ChampionInfo;
use RiotQuest\Components\Engine\Request;
use RiotQuest\Contracts\LeagueException;

/**
 * Class League
 *
 * Platform to perform all Champion MasteryTest V4 related calls.
 *
 * @package RiotQuest\Components\Riot\Endpoints
 */
class Champion extends Template
{

    /**
     * @see https://developer.riotgames.com/api-methods/#champion-v3/GET_getChampionInfo
     *
     * @return ChampionInfo
     * @throws LeagueException
     * @throws InvalidArgumentException
     */
    public function rotation(): ChampionInfo
    {
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/platform/v3/champion-rotations')
            ->with('ttl', $this->ttl)
            ->with('function', 'champion.rotation')
            ->with('region', $this->region)
            ->send();
    }

}
