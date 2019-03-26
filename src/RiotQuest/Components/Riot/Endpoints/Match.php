<?php

namespace RiotQuest\Components\Riot\Endpoints;

use RiotQuest\Components\Http\Request;

/**
 * Class League
 *
 * Platform to perform all Match V4 related calls.
 *
 * @package RiotQuest\Components\Riot\Endpoints
 */
class Match extends Template
{

    /**
     * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatchlist
     *
     * @param $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function list($id)
    {
        return Request::make(['match', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/match/v4/matchlists/by-account/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->send();
    }

    public function timeline($id)
    {
        return Request::make(['match', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/match/v4/timelines/by-match/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->send();
    }

    public function id($id)
    {
        return Request::make(['match', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/match/v4/matches/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->send();
    }

}
