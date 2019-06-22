<?php

namespace RiotQuest\Components\Collections;

use RiotQuest\Components\DataProviders\Provider;

/**
 * Class BannedChampion
 *
 * @see https://developer.riotgames.com/api-methods/#spectator-v4/GET_getFeaturedGames
 *
 * @property int $pickTurn The pick turn this ban was made
 * @property double $championId The champion ID for the ban
 * @property double $teamId ID for the team who banned this champion
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class BannedChampion extends Collection
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

    /**
     * Get champion name for banned champion
     *
     * @return string
     */
    public function getChampionName()
    {
        return Provider::getChampionName($this->championId);
    }

}
