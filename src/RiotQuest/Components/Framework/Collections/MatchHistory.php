<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class MatchHistory
 *
 * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatchlist
 *
 * @property MatchReferenceList $matches Match reference list
 * @property int $totalGames Total amount of games ( might be bugged due to Riot bug )
 * @property int $startIndex Start index in match list
 * @property int $endIndex End index in match list
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class MatchHistory extends Collection
{

    /**
     * Checks if given match is in this list
     *
     * @param $id
     * @return bool
     */
    public function getMatch($id)
    {
        $matches = $this->matches->filter(function (MatchReference $e) use ($id) {
            return $e->gameId == $id;
        });
        return count($matches) ? $matches[0] : false;
    }

    /**
     * Pulls all matches where Queue is given id
     *
     * @param $id
     * @return MatchHistory
     */
    public function getWhereQueue($id)
    {
        $matches = array_values($this->matches->filter(function (MatchReference $e) use ($id) {
            return $e->queue == $id;
        }));
        return new static([
            'matches' => new MatchReferenceList($matches),
            'totalGames' => count($matches),
            'startIndex' => 0,
            'endIndex' => count($matches)
        ], $this->region);
    }

    /**
     * Pulls all matches where Champion is given id
     *
     * @param $id
     * @return MatchHistory
     */
    public function getWhereChampion($id)
    {
        $matches = array_values($this->matches->filter(function (MatchReference $e) use ($id) {
            return $e->champion == $id;
        }));
        return new static([
            'matches' => new MatchReferenceList($matches),
            'totalGames' => count($matches),
            'startIndex' => 0,
            'endIndex' => count($matches)
        ], $this->region);
    }

    /**
     * Pulls all matches where Season is given id
     *
     * @param $id
     * @return MatchHistory
     */
    public function getWhereSeason($id)
    {
        $matches = array_values($this->matches->filter(function (MatchReference $e) use ($id) {
            return $e->season == $id;
        }));
        return new static([
            'matches' => new MatchReferenceList($matches),
            'totalGames' => count($matches),
            'startIndex' => 0,
            'endIndex' => count($matches)
        ], $this->region);
    }

}
