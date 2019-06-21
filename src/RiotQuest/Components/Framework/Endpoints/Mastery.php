<?php

namespace RiotQuest\Components\Framework\Endpoints;

use GuzzleHttp\Exception\GuzzleException;
use Psr\SimpleCache\InvalidArgumentException;
use ReflectionException;
use RiotQuest\Components\Framework\Collections\ChampionMastery;
use RiotQuest\Components\Framework\Collections\ChampionMasteryList;
use RiotQuest\Components\Framework\Engine\Request;
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
     * @throws GuzzleException
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws LeagueException
     */
    public function all(string $id): ChampionMasteryList
    {
        return Request::make(['mastery', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#champion-mastery-v4/GET_getChampionMastery
     *
     * @param $id
     * @param ChampionMastery
     * @return mixed
     * @throws GuzzleException
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws LeagueException
     */
    public function id(string $id, $champion): ChampionMastery
    {
        return Request::make(['mastery', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/{id}/by-champion/{champion}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id, 'champion' => $champion])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#champion-mastery-v4/GET_getChampionMasteryScore
     *
     * @param $id
     * @return integer
     * @throws GuzzleException
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws LeagueException
     */
    public function score(string $id): int
    {
        return Request::make(['mastery', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/champion-mastery/v4/scores/by-summoner/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

}
