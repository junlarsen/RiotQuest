<?php

namespace RiotQuest\Components\Endpoints;

use RiotQuest\Components\Collections\Match as MatchCollection;
use RiotQuest\Components\Collections\MatchHistory;
use RiotQuest\Components\Collections\MatchTimeline;
use RiotQuest\Components\Engine\Request;
use RiotQuest\Contracts\LeagueException;

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
     * @throws LeagueException
     */
    public function list(string $id, array $filters = []): MatchHistory
    {
        $filters = array_merge([
            'startIndex' => null,
            'endIndex' => null,
            'queue' => null,
            'champion' => null,
            'season' => null,
            'beginTime' => null,
            'endTime' => null
        ], $filters);

        $filters = array_map(function ($e) {
            return (array)$e;
        }, $filters);

        $str = '';

        foreach ($filters as $key => $value) {
            foreach ($value as $item) {
                if ($item) $str .= '&' . http_build_query([$key => $item]);
            }
        }

        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/match/v4/matchlists/by-account/{?}' . ($str ? '?' . trim($str, '&') : ''))
            ->with('ttl', $this->ttl)
            ->with('function', 'match.list')
            ->with('arguments', [$id])
            ->with('region', $this->region)
            ->send();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatchTimeline
     *
     * @param $id
     * @return MatchTimeline
     * @throws LeagueException
     */
    public function timeline($id): MatchTimeline
    {
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/match/v4/timelines/by-match/{?}')
            ->with('ttl', $this->ttl)
            ->with('function', 'match.timeline')
            ->with('arguments', [$id])
            ->with('region', $this->region)
            ->send();
    }

    /**
     * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatch
     *
     * @param $id
     * @return MatchCollection
     * @throws LeagueException
     */
    public function id($id): MatchCollection
    {
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/match/v4/matches/{?}')
            ->with('ttl', $this->ttl)
            ->with('function', 'match.id')
            ->with('arguments', [$id])
            ->with('region', $this->region)
            ->send();
    }

}
