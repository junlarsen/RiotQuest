<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class LeaguePositionList
 *
 * @list LeaguePosition
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class LeaguePositionList extends Collection
{

    public function solo()
    {
        return array_filter($this->stack, function ($e) {
            return $e['queueType'] === 'RANKED_SOLO_5x5';
        })[0];
    }

    public function treeline()
    {
        return array_filter($this->stack, function ($e) {
            return $e['queueType'] === 'RANKED_FLEX_SR';
        })[0];
    }

    public function flex()
    {
        return array_filter($this->stack, function ($e) {
            return $e['queueType'] === 'RANKED_FLEX_TT';
        })[0];
    }
    
}
