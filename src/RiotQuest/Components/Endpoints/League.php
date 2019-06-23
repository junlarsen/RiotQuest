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
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/league/v4/entries/by-summoner/{?}')
            ->with('ttl', $this->ttl)
            ->with('function', 'league.positions')
            ->with('arguments', [$id])
            ->with('region', $this->region)
            ->send();
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
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/league/v4/leagues/{?}')
            ->with('ttl', $this->ttl)
            ->with('function', 'league.id')
            ->with('arguments', [$id])
            ->with('region', $this->region)
            ->send();
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
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/league/v4/entries/{?}/{?}/{?}?page={?}')
            ->with('ttl', $this->ttl)
            ->with('function', 'league.entries')
            ->with('arguments', [$queue, $tier, $division, $page])
            ->with('region', $this->region)
            ->send();
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
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/league/v4/challengerleagues/by-queue/{?}')
            ->with('ttl', $this->ttl)
            ->with('function', 'league.challenger')
            ->with('arguments', [$queue])
            ->with('region', $this->region)
            ->send();
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
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/league/v4/masterleagues/by-queue/{?}')
            ->with('ttl', $this->ttl)
            ->with('function', 'league.challenger')
            ->with('arguments', [$queue])
            ->with('region', $this->region)
            ->send();
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
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/league/v4/grandmasterleagues/by-queue/{?}')
            ->with('ttl', $this->ttl)
            ->with('function', 'league.challenger')
            ->with('arguments', [$queue])
            ->with('region', $this->region)
            ->send();
    }

}
