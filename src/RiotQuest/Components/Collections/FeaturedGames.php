<?php

namespace RiotQuest\Components\Collections;

/**
 * Class FeaturedGames
 *
 * @see https://developer.riotgames.com/api-methods/#spectator-v4/GET_getFeaturedGames
 *
 * @property double $clientRefreshInterval
 * @property FeaturedGameInfoList $gameList List of games featured at the moment
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class FeaturedGames extends Collection
{

    /**
     * Get game IDs
     *
     * @return array
     */
    public function getGameIds()
    {
        return $this->mapArr(function (FeaturedGameInfo $featuredGameInfo) {
            return $featuredGameInfo->gameId;
        });
    }

}
