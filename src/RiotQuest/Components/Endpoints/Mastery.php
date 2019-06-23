<?php

namespace RiotQuest\Components\Endpoints;

use RiotQuest\Components\Collections\ChampionMastery;
use RiotQuest\Components\Collections\ChampionMasteryList;
use RiotQuest\Components\Engine\Request;
use RiotQuest\Contracts\LeagueException;

/**
 * Class League
 *
 * Platform to perform all Champion MasteryTest V4 related calls.
 *
 * @package RiotQuest\Components\Riot\Endpoints
 */
class Mastery extends Template
{

    /**
     * @see https://developer.riotgames.com/api-methods/#champion-mastery-v4/GET_getAllChampionMasteries
     *
     * @param $id
     * @return ChampionMasteryList
     * @throws LeagueException
     */
    public function all(string $id): ChampionMasteryList
    {
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/{?}')
            ->with('ttl', $this->ttl)
            ->with('function', 'mastery.all')
            ->with('arguments', [$id])
            ->with('region', $this->region)
            ->send();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#champion-mastery-v4/GET_getChampionMastery
     *
     * @param $id
     * @param ChampionMastery
     * @return mixed
     * @throws LeagueException
     */
    public function id(string $id, $champion): ChampionMastery
    {
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/{?}/by-champion/{?}')
            ->with('ttl', $this->ttl)
            ->with('function', 'mastery.id')
            ->with('arguments', [$id, $champion])
            ->with('region', $this->region)
            ->send();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#champion-mastery-v4/GET_getChampionMasteryScore
     *
     * @param $id
     * @return integer
     * @throws LeagueException
     */
    public function score(string $id): int
    {
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/champion-mastery/v4/scores/by-summoner/{?}')
            ->with('ttl', $this->ttl)
            ->with('function', 'mastery.score')
            ->with('arguments', [$id])
            ->with('region', $this->region)
            ->send();
    }

}
