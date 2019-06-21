<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class League
 *
 * @see https://developer.riotgames.com/api-methods/#league-v4/GET_getAllLeaguePositionsForSummoner
 *
 * @property string $leagueId The league ID of this league
 * @property string $tier Which tier this league is: IRON, BRONZE etc.
 * @property LeagueItemList $entries Players in this league
 * @property string $queue Queue type for this league, flex, 3v3 or soloQ
 * @property string $name The league's name
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class League extends Collection
{

    /**
     * Get player in league where summoner ID is equal to given ID
     *
     * @param $id
     * @return LeagueItem
     */
    public function getPlayerWhereId(string $id)
    {
        return array_values($this->mapArr(function (LeagueItem $leagueItem) use ($id) {
                return $leagueItem->summonerId == $id;
            }))[0] ?? null;
    }

}
