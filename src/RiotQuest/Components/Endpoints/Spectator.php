<?php

namespace RiotQuest\Components\Endpoints;

use RiotQuest\Components\Collections\CurrentGameInfo;
use RiotQuest\Components\Collections\FeaturedGames;
use RiotQuest\Components\Engine\Request;
use RiotQuest\Contracts\LeagueException;

/**
 * Class League
 *
 * Platform to perform all Spectator V4 related calls.
 *
 * @package RiotQuest\Components\Riot\Endpoints
 */
class Spectator extends Template
{

    /**
     * @see https://developer.riotgames.com/api-methods/#spectator-v4/GET_getFeaturedGames
     *
     * @return FeaturedGames
     * @throws LeagueException
     */
    public function featured(): FeaturedGames
    {
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/spectator/v4/featured-games')
            ->with('ttl', $this->ttl)
            ->with('function', 'spectator.featured')
            ->with('region', $this->region)
            ->send();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#spectator-v4/GET_getCurrentGameInfoBySummoner
     *
     * @param $id
     * @return CurrentGameInfo
     * @throws LeagueException
     */
    public function active(string $id): CurrentGameInfo
    {
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/spectator/v4/active-games/by-summoner/{?}')
            ->with('ttl', $this->ttl)
            ->with('function', 'spectator.active')
            ->with('arguments', [$id])
            ->with('region', $this->region)
            ->send();
    }

}
