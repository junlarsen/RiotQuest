<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class MatchEventList
 *
 * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatchTimeline
 *
 * @list MatchEvent
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class MatchEventList extends Collection
{

    /**
     * Get amounts of events in stack
     *
     * @return int
     */
    public function getEventCount()
    {
        return count($this->items);
    }

}
