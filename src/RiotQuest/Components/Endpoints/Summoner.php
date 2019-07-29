<?php

namespace RiotQuest\Components\Endpoints;

use Psr\Cache\InvalidArgumentException;
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
     * @param string $id
     * @return SummonerCollection
     * @throws LeagueException
     * @throws InvalidArgumentException
     */
    public function account(string $id): SummonerCollection
    {
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/summoner/v4/summoners/by-account/{?}')
            ->with('ttl', $this->ttl)
            ->with('arguments', [$id])
            ->with('function', 'summoner.account')
            ->with('region', $this->region)
            ->send();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#summoner-v4/GET_getBySummonerName
     *
     * @param string $id
     * @return SummonerCollection
     * @throws LeagueException
     * @throws InvalidArgumentException
     */
    public function name(string $id): SummonerCollection
    {
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/summoner/v4/summoners/by-name/{?}')
            ->with('ttl', $this->ttl)
            ->with('arguments', [$id])
            ->with('function', 'summoner.name')
            ->with('region', $this->region)
            ->send();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#summoner-v4/GET_getByPUUID
     *
     * @param string $id
     * @return SummonerCollection
     * @throws LeagueException
     * @throws InvalidArgumentException
     */
    public function unique(string $id): SummonerCollection
    {
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/summoner/v4/summoners/by-puuid/{?}')
            ->with('ttl', $this->ttl)
            ->with('arguments', [$id])
            ->with('function', 'summoner.unique')
            ->with('region', $this->region)
            ->send();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#summoner-v4/GET_getBySummonerId
     *
     * @param string $id
     * @return SummonerCollection
     * @throws LeagueException
     * @throws InvalidArgumentException
     */
    public function id(string $id): SummonerCollection
    {
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/summoner/v4/summoners/{?}')
            ->with('ttl', $this->ttl)
            ->with('arguments', [$id])
            ->with('function', 'summoner.id')
            ->with('region', $this->region)
            ->send();
    }

}
