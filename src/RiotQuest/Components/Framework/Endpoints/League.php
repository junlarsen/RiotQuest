<?php

namespace RiotQuest\Components\Framework\Endpoints;

use RiotQuest\Components\Framework\Collections\LeaguePositionList;
use RiotQuest\Components\Framework\Engine\Request;

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
     * @return LeaguePositionList
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function positions($id)
    {
        return Request::make(['league', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/league/v4/positions/by-summoner/{id}')
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
     * @return \RiotQuest\Components\Framework\Collections\League
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function id($id)
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
     * @see https://developer.riotgames.com/api-methods/#league-v4/GET_getChallengerLeague
     *
     * @param $queue
     * @return \RiotQuest\Components\Framework\Collections\League
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function challenger($queue)
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
     * @return \RiotQuest\Components\Framework\Collections\League
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function master($queue)
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
     * @return \RiotQuest\Components\Framework\Collections\League
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function grandmaster($queue)
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
