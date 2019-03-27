<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class LeaguePositionList
 *
 * @see https://developer.riotgames.com/api-methods/#league-v4/GET_getAllLeaguePositionsForSummoner
 *
 * @list LeaguePosition
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class LeaguePositionList extends Collection
{

    public function solo(): LeaguePosition
    {
        return array_filter($this->stack, function ($e) {
            return $e['queueType'] === 'RANKED_SOLO_5x5';
        })[0];
    }

    public function treeline(): LeaguePosition
    {
        return array_filter($this->stack, function ($e) {
            return $e['queueType'] === 'RANKED_FLEX_SR';
        })[0];
    }

    public function flex(): LeaguePosition
    {
        return array_filter($this->stack, function ($e) {
            return $e['queueType'] === 'RANKED_FLEX_TT';
        })[0];
    }

}
