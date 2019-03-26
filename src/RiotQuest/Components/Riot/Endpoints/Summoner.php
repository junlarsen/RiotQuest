<?php

namespace RiotQuest\Components\Riot\Endpoints;

use RiotQuest\Components\Http\Request;

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
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function account($id)
    {
        return Request::make(['summoner', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/summoner/v4/summoners/by-account/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->send();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#summoner-v4/GET_getBySummonerName
     *
     * @param $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function name($id)
    {
        return Request::make(['summoner', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/summoner/v4/summoners/by-name/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->send();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#summoner-v4/GET_getByPUUID
     *
     * @param $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function unique($id)
    {
        return Request::make(['summoner', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/summoner/v4/summoners/by-puuid/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->send();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#summoner-v4/GET_getBySummonerId
     *
     * @param $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function id($id)
    {
        return Request::make(['summoner', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/summoner/v4/summoners/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->send();
    }

}
