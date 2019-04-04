<?php

namespace RiotQuest\Components\Framework\Endpoints;

use RiotQuest\Components\Framework\Collections\MatchHistory;
use RiotQuest\Components\Framework\Collections\MatchTimeline;
use RiotQuest\Components\Framework\Engine\Request;

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
     * @param $filters
     * @return MatchHistory
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function list($id, $filters = [])
    {
        $filters = array_merge([
            'startIndex' => false,
            'endIndex' => false,
            'queue' => [],
            'champion' => [],
            'season' => [],
            'beginTime' => false,
            'endTime' => false
        ], $filters);
        $filters = array_map(function ($e) {
            return (array) $e;
        }, $filters);
        $str = '';
        foreach ($filters as $key => $value) {
             foreach ($value as $item) {
                 if ($item) $str .= '&' . http_build_query([$key => $item]);
             }
        }

        return Request::make(['match', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/match/v4/matchlists/by-account/{id}?' . trim($str, '&'))
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatchTimeline
     *
     * @param $id
     * @return MatchTimeline
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function timeline($id)
    {
        return Request::make(['match', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/match/v4/timelines/by-match/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatch
     *
     * @param $id
     * @return \RiotQuest\Components\Framework\Collections\Match
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function id($id)
    {
        return Request::make(['match', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/match/v4/matches/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

}
