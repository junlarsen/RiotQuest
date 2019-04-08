<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class FeaturedGameInfoList
 *
 * @see https://developer.riotgames.com/api-methods/#spectator-v4/GET_getFeaturedGames
 *
 * @list FeaturedGameInfo
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class FeaturedGameInfoList extends Collection
{

    /**
     * Get a list of game ids
     *
     * @return Collection
     */
    public function getGameIds()
    {
        return new Collection(array_values($this->map(function (FeaturedGameInfo $e) {
            return $e->gameId;
        })));
    }

}
