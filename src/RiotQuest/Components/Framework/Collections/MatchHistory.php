<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class MatchHistory
 *
 * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatchlist
 *
 * @property MatchReferenceList $matches
 * @property int $totalGames
 * @property int $startIndex
 * @property int $endIndex
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
    public function findMatch($id)
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
     * @return array
     */
    public function whereQueue($id)
    {
        return $this->matches->filter(function (MatchReference $e) use ($id) {
            return $e->queue == $id;
        });
    }

    /**
     * Pulls all matches where Champion is given id
     *
     * @param $id
     * @return array
     */
    public function whereChampion($id)
    {
        return $this->matches->filter(function (MatchReference $e) use ($id) {
            return $e->champion == $id;
        });
    }

    /**
     * Pulls all matches where Season is given id
     *
     * @param $id
     * @return array
     */
    public function whereSeason($id)
    {
        return $this->matches->filter(function (MatchReference $e) use ($id) {
            return $e->season == $id;
        });
    }

}
