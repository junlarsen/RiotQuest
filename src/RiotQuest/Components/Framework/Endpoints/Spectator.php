<?php

namespace RiotQuest\Components\Framework\Endpoints;

use RiotQuest\Components\Framework\Collections\CurrentGameInfo;
use RiotQuest\Components\Framework\Collections\FeaturedGames;
use RiotQuest\Components\Framework\Engine\Request;
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
        return Request::make(['spectator', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/spectator/v4/featured-games')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
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
        return Request::make(['spectator', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/spectator/v4/active-games/by-summoner/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

}
