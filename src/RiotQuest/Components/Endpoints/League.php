<?php

namespace RiotQuest\Components\Endpoints;

use RiotQuest\Components\Collections\League as LeagueCollection;
use RiotQuest\Components\Collections\LeagueEntryList;
use RiotQuest\Components\Engine\Request;
use RiotQuest\Contracts\LeagueException;

/**
 * Class League
 *
 * Platform to perform all League V4 related calls.
 *
 * @package RiotQuest\Components\Riot\Endpoints
 */
class League extends Template
{

    /**
     * @see https://developer.riotgames.com/api-methods/#league-v4/GET_getAllLeaguePositionsForSummoner
     *
     * @param $id
     * @return LeagueEntryList
     * @throws LeagueException
     */
    public function positions(string $id): LeagueEntryList
    {
        return Request::make(['league', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/league/v4/entries/by-summoner/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#league-v4/GET_getLeagueById
     *
     * @param $id
     * @return LeagueCollection
     * @throws LeagueException
     */
    public function id(string $id): LeagueCollection
    {
        return Request::make(['league', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/league/v4/leagues/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#league-v4/GET_getLeagueEntries
     *
     * @param string $queue
     * @param string $tier
     * @param string $division
     * @param int $page
     * @return LeagueEntryList
     * @throws LeagueException
     */
    public function entries(string $queue, string $tier, string $division, $page = 1): LeagueEntryList
    {
        return Request::make(['league', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/league/v4/entries/{queue}/{tier}/{division}?page={page}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'queue' => $queue, 'tier' => $tier, 'division' => $division, 'page' => $page])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#league-v4/GET_getChallengerLeague
     *
     * @param $queue
     * @return LeagueCollection
     * @throws LeagueException
     */
    public function challenger(string $queue): LeagueCollection
    {
        return Request::make(['league', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/league/v4/challengerleagues/by-queue/{queue}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'queue' => $queue])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#league-v4/GET_getMasterLeague
     *
     * @param $queue
     * @return LeagueCollection
     * @throws LeagueException
     */
    public function master(string $queue): LeagueCollection
    {
        return Request::make(['league', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/league/v4/masterleagues/by-queue/{queue}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'queue' => $queue])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#league-v4/GET_getGrandmasterLeague
     *
     * @param $queue
     * @return LeagueCollection
     * @throws LeagueException
     */
    public function grandmaster(string $queue): LeagueCollection
    {
        return Request::make(['league', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/league/v4/grandmasterleagues/by-queue/{queue}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'queue' => $queue])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

}
