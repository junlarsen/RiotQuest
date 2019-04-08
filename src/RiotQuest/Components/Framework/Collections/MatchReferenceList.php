<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class MatchReferenceList
 *
 * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatchlist
 *
 * @list MatchReference
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class MatchReferenceList extends Collection
{

    /**
     * Count total games in stack
     *
     * @return int
     */
    public function getTotalGames()
    {
        return count($this->stack);
    }

}
