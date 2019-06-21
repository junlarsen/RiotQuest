<?php

namespace RiotQuest\Components\Framework\Endpoints;

use GuzzleHttp\Exception\GuzzleException;
use Psr\SimpleCache\InvalidArgumentException;
use ReflectionException;
use RiotQuest\Components\Framework\Collections\ChampionInfo;
use RiotQuest\Components\Framework\Engine\Request;
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
     * @throws GuzzleException
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws LeagueException
     */
    public function rotation(): ChampionInfo
    {
        return Request::make(['champion', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/platform/v3/champion-rotations')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

}
