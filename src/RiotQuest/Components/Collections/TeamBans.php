<?php

namespace RiotQuest\Components\Collections;

use RiotQuest\Components\DataProviders\Provider;

/**
 * Class TeamBans
 *
 * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatch
 *
 * @property int $pickTurn Which turn this ban was made
 * @property int $championId ID of champion who was banned
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class TeamBans extends Collection
{

    /**
     * Get champion icon for banned champion
     *
     * @return string
     */
    public function getChampionIcon()
    {
        return Provider::getChampionSquare(Provider::getChampionId($this->championId));
    }

}
