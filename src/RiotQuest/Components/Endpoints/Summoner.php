<?php

namespace RiotQuest\Components\Endpoints;

use RiotQuest\Components\Collections\Summoner as SummonerCollection;
use RiotQuest\Components\Engine\Request;
use RiotQuest\Contracts\LeagueException;

/**
 * Class Summoner
 *
 * Platform to request all Summoner V4 related calls.
 *
 * @package RiotQuest\Components\Riot\Endpoints
 */
class Summoner extends Template
{

    /**
     * @see https://developer.riotgames.com/api-methods/#summoner-v4/GET_getByAccountId
     *
     * @param $id
     * @return SummonerCollection
     * @throws LeagueException
     */
    public function account(string $id): SummonerCollection
    {
        return Request::make(['summoner', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/summoner/v4/summoners/by-account/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#summoner-v4/GET_getBySummonerName
     *
     * @param string $id
     * @return SummonerCollection
     * @throws LeagueException
     */
    public function name(string $id): SummonerCollection
    {
        return Request::make(['summoner', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/summoner/v4/summoners/by-name/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#summoner-v4/GET_getByPUUID
     *
     * @param $id
     * @return SummonerCollection
     * @throws LeagueException
     */
    public function unique(string $id): SummonerCollection
    {
        return Request::make(['summoner', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/summoner/v4/summoners/by-puuid/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#summoner-v4/GET_getBySummonerId
     *
     * @param $id
     * @return SummonerCollection
     * @throws LeagueException
     */
    public function id(string $id): SummonerCollection
    {
        return Request::make(['summoner', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/summoner/v4/summoners/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

}