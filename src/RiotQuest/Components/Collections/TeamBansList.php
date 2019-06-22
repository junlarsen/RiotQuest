<?php

namespace RiotQuest\Components\Collections;

/**
 * Class TeamBansList
 *
 * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatch
 *
 * @list TeamBans
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class TeamBansList extends Collection
{

    /**
     * Get a list of banned champion ids
     *
     * @return array
     */
    public function getBannedIds()
    {
        return $this->mapArr(function (TeamBans $e) {
            return $e->championId;
        });
    }

}
